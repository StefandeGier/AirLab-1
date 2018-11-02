/**
*   Knockoutjs
*/

var dashModel = function (){
  var self = this
  self.currentTemplate = ko.observable('blueprintPage')
  self.nav = ko.observable(true)
  self.token = ko.observable()
  self.blueprintData = ko.observableArray() 
  self.devices = ko.observableArray()
  self.currentBlueprint = ko.observable({ id:'1', name:'example', path:'/AjZx9PYst2lIXcg7ASdBwYTBBm2ZIH17yz9UE7el.jpeg'})
  if (localStorage.getItem('token'))
  {
    self.token(localStorage.getItem('token'))
  }
  self.loadModel = function(data) {
    switch(data) {
      case 'dash':
        ko.cleanNode($("#main")[0])
        var newModel = new dashModel()
        ko.applyBindings(newModel)
        break
      case 'pro':
        ko.cleanNode($("#main")[0])
        var newModel = new profileModel()
        ko.applyBindings(newModel)
        break
      case 'dev':
        ko.cleanNode($("#main")[0])
        var newModel = new adminDevicesModel()
        ko.applyBindings(newModel)
        break
      case 'out':
        ko.cleanNode($("#main")[0])
        var newModel = new logoutModel()
        ko.applyBindings(newModel)
        break
    }
  }  
  self.selectFunc = function(){
    let canvas = document.getElementById("currentBP")
    let context = canvas.getContext("2d")
    context.clearRect(0, 0, canvas.width, canvas.height)
    let path = self.currentBlueprint()['path']
    console.log(self.currentBlueprint())
    let img = new Image()
    img.src = base_url + '/storage/' + path
    img.addEventListener("load", function() {
      context.drawImage(img, 
      canvas.width / 2 - img.width / 2,
      canvas.height / 2 - img.height / 2
      )
    })
  }
  self.deleteBP = function(){
    $.post(base_url + '/api/blueprint/delete',{id:self.currentBlueprint().id})
  }


  self.changeNameBTN = function(){
    let id =  self.currentBlueprint()['id']
    let oldie = self.currentBlueprint()
    self.currentBlueprint().name = $('#changeName').val()
    $.post(base_url + "/api/blueprint/changeName",{name:$('#changeName').val(),id:id}).done(function(){
      self.blueprintData.replace(oldie,self.currentBlueprint())
      console.log(self.blueprintData())
    })
  }
  
  /**
  *
  *   Upload image
  */
  self.fileSelect = function (element,event) {
    var files =  event.target.files// FileList object
    // Loop through the FileList and render image files as thumbnails.
    var canvas = document.getElementById('background')
  	var context = canvas.getContext('2d')
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue
      }
      var reader = new FileReader()

      // Closure to capture the file information.
      reader.onload = (function() {
        return function(event){
          var img = new Image()
          img.addEventListener("load", function() {
            context.drawImage(img,
              canvas.width / 2 - img.width / 2,
              canvas.height / 2 - img.height / 2
              )
          })
          img.src = event.target.result
        }
      })(f)
      var formData = new FormData()

      // HTML file input, chosen by user
      formData.append("blueprint", f)
      formData.append("token", self.token())

      var request = new XMLHttpRequest()
      request.open("POST", base_url + '/api/blueprint/upload')
      request.send(formData)
      // Read in the image file as a data URL.
      reader.readAsDataURL(f)
    }
  }
    /**
     * Toggle dropdown function
     */
    $('#list').hide()
    //toggle button text
    $('button').click(function () {
        $('span', this).toggle();
    });
    //toggle list
    $('button').click(function () {
        $('#list').toggle('slow');
    });



/**
 * Display blueprint and drag n drop devices onto blueprint
 * @return {[type]} [description]
 */
  self.enterPage = function () {
    $.post(base_url + '/api/blueprint/devices/get').done(function(data) {
        self.devices(data)
        console.log(data)
        
    })
    $.get(base_url + '/api/blueprint/get').done(function(data){
      for (var i = 0, d; d = data[i]; i++) {
        self.blueprintData.push({ id:d.id, name:d.name, path:d.path.replace('public/', '')})
        console.log(self.blueprintData())
      }
      document.addEventListener('mousedown', function(event) {
          event.preventDefault();
          let dragElement = event.target.closest('.draggable');
          if (!dragElement) return;
          let coords, shiftX, shiftY;
          startDrag(event.clientX, event.clientY);
          document.addEventListener('mousemove', onMouseMove);

          // on drag start:
          //   remember the initial shift
          //   move the element position:fixed and a direct child of body
          function startDrag(clientX, clientY) {
              event.preventDefault();
              shiftX = clientX - dragElement.getBoundingClientRect().left;
              shiftY = clientY - dragElement.getBoundingClientRect().top;
              dragElement.style.position = 'fixed';
              document.body.append(dragElement);
              moveAt(clientX, clientY);
          };

          // switch to absolute coordinates at the end, to fix the element in the document
          function finishDrag() {
              dragElement.style.top = parseInt(dragElement.style.top) + pageYOffset + 'px';
              dragElement.style.left = parseInt(dragElement.style.left) + pageXOffset + 'px';
              dragElement.style.position = 'absolute';
              document.removeEventListener('mousemove', onMouseMove);
              dragElement.onmouseup = null;
              $.post(base_url + '/api/blueprint/coordinations/get', {blueprintData: [{left: dragElement.style.left, top: dragElement.style.top, id: data[0].id, device_id: dragElement.id}]}).done(function(data) {
                console.log(dragElement.style.left)
                console.log(dragElement.style.top)
                console.log(dragElement.id)
              });
          }

          dragElement.onmouseup = function(event) {
              event.preventDefault();
              finishDrag();
          };

          function onMouseMove(event) {
              event.preventDefault();
              moveAt(event.clientX, event.clientY);
          }

          function moveAt(clientX, clientY) {
              // new window-relative coordinates
              let newX = clientX - shiftX;
              let newY = clientY - shiftY;
              // check if the new coordinates are below the bottom window edge
              let newBottom = newY + dragElement.offsetHeight; // new bottom
              // below the window? let's scroll the page
              if (newBottom > document.documentElement.clientHeight) {
                  // window-relative coordinate of document end
                  let docBottom = document.documentElement.getBoundingClientRect().bottom;
                  // scroll the document down by 10px has a problem
                  // it can scroll beyond the end of the document
                  // Math.min(how much left to the end, 10)
                  let scrollY = Math.min(docBottom - newBottom, 10);
                  // calculations are imprecise, there may be rounding errors that lead to scrolling up
                  // that should be impossible, fix that here
                  if (scrollY < 0) scrollY = 0;
                  window.scrollBy(0, scrollY);
                  // a swift mouse move make put the cursor beyond the document end
                  // if that happens -
                  // limit the new Y by the maximally possible (right at the bottom of the document)
                  newY = Math.min(newY, document.documentElement.clientHeight - dragElement.offsetHeight);
              }

              // check if the new coordinates are above the top window edge (similar logic)
              if (newY < 0) {
                  // scroll up
                  let scrollY = Math.min(-newY, 10);
                  if (scrollY < 0) scrollY = 0; // check precision errors
                  window.scrollBy(0, -scrollY);
                  // a swift mouse move can put the cursor beyond the document start
                  newY = Math.max(newY, 0); // newY may not be below 0
              }

              // limit the new X within the window boundaries
              // there's no scroll here so it's simple
              if (newX < 0) newX = 0;
              if (newX > document.documentElement.clientWidth - dragElement.offsetWidth) {
                  newX = document.documentElement.clientWidth - dragElement.offsetWidth;
              }

              dragElement.style.left = newX + 'px';
              dragElement.style.top = newY + 'px';
          }
          })
        })
        $.post(base_url + '/api/blueprint/devices/get').done(function(data) {
          data.forEach(function(element) {
            var btn = document.createElement("BUTTON");
            var t = document.createTextNode(element.name);
            let toppixel = element.top_pixel - 79

            btn.style.position = 'absolute';
            btn.className = "btn btn-info draggable";
            btn.id = element.id;
            btn.style.left = element.left_pixel +'px';
            btn.style.top = toppixel +'px';
            btn.appendChild(t);
            document.getElementById("bp").appendChild(btn);
          })
        })
    }
    self.enterPage()



}