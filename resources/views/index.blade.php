@extends('layouts.app')

@section('content')




            <script type="text/html" id='profileTemplate'>
<div class="container-fluid d-none" id="container">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bind="click: toggleVisibilityProfile">
                            <button class="btn btn-info col" type="button"> Profile</button>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bind="click: toggleVisibilityDevices">
                            <button class="btn btn-info col" type="button"> Devices</button>
                        </a>
                    </li>
                    <div class = 'admin'>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bind="click: toggleVisibilityRecords">
                            <button class="btn btn-info col" type="button"> Records</button>
                        </a>
                    </li>
                    </div>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bind="click: logout">
                            <button class="btn btn-danger col" type="button"> Logout</button>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" class = 'admin'>
            <div id="currentTab">
                <h2 data-bind="text: user"></h2>
                <div data-bind="visible: showRow">
                    <p data-bind="text: currentTab"></p>
                    <!-- ALL devices [LARS] -->
                    <div data-bind="foreach: allColorDevices" class="card-columns">
                        <div class="card text-white  mb-3" data-bind="css: $data.color " style="max-width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title d-inline" data-bind="text: $data.name"></h5>
                                <!-- <a data-toggle="modal" data-target="#editNameModal" data-id="bla"><i class="fas fa-edit d-inline float-right"></i></a>-->
                                <p class="card-text" data-bind="text: $data.message"></p>
                            </div>
                        </div>
                    </div> 
                <div>
                    <p>Profile</p>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr data-bind="foreach: currentTabHead">
                                <th data-bind="text: name"></th>
                            </tr>
                        </thead>
                            <tbody data-bind="foreach: $root.currentTabData" >
                                <tr>
                                    <td data-bind="text:name"></td>
                                    <td data-bind="text:email"></td>
                                </tr>
                            </tbody>
                    </table>
                    <div>
                        <a href="#" data-bind="click: openBtn">
                            <button type="button" class="btn btn-outline-dark">Change Password</button>
                        </a>
                        <!--                         
                            <a href="">
                            <button type="button" class="btn btn-outline-dark">Change Email</button>                            
                        </a> -->
                    </div>
                </div>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body form-horizontal">
                            <form data-bind="submit: saveToPhp" id="pass_form">
                                <div class="form-group">
                                  <div class="control-group">
                                        <label for="current_password" class="control-label">Current Password</label>
                                        <div class="controls">
                                            <input type="password" data-bind="value: current_password" class="form-control"  name="current_password">
                                        </div>
                                    </div>

                                                <div class="control-group">
                                                    <label for="new_password" class="control-label">New Password</label>
                                                    <div class="controls">
                                                        <input type="password" data-bind="value: new_password" class="form-control"  name="new_password">
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label for="confirm_password" class="control-label">Confirm Password</label>
                                                    <div class="controls">
                                                        <input type="password" data-bind="value: confirm_password" class="form-control"  name="confirm_password">
                                                    </div>
                                                </div>

                                    <div class="modal-footer">
                                        <button href="#" class="btn" data-dismiss="modal" aria-hidden="true" id="password_modal_save">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </script>

            <script type="text/html" id="deviceTemplate">
<<<<<<< HEAD
                    <p>Devices</p>
=======

                <div data-bind="visible: showDev">
                    <p data-bind="text: currentTab"></p>
>>>>>>> ffcac5cead3faf6da52fc1b5a85f335be0d9192d
                    <!--Admin device to organization-->
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card" style="margin:50px 0">
                                    <!-- Default panel contents -->
                                    <div class="card-header">Organizations</div>
                                    <ul class="list-group list-group-flush" style="overflow: auto; height: 15em;">
                                      <div data-bind="foreach: organization">
                                        <li class="list-group-item">
                                            <span data-bind="text: $data.name"></span>
                                            <label class="checkbox">
                                                <input type="radio" name="organization" data-bind="value: id, click: $root.organizationRadiobox" />
                                                <span class="success"></span>
                                            </label>
                                        </li>
                                      </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                  <div data-bind='visible: showOrgDevices' class="col-md-12">
                      <div class="card" style="margin:50px 0">
                          <!-- Default panel contents -->
                          <div class="card-header">Devices from organization</div>
                          <ul class="list-group list-group-flush" style="overflow: auto; height: 15em;">
                            <div data-bind="foreach: devicesOrganization">
                              <li class="list-group-item">
                                  <span data-bind="text: $data.name"></span>
                                  <label class="checkbox">
                                      <input type="checkbox" data-bind="value: id" name="devicesOrganization" />
                                      <span class="success"></span>
                                  </label>
                              </li>
                            </div>
                          </ul>
                          <div class="card-footer">
                            <button class="btn btn-danger" data-bind="click: devicesOwner" type="button" name="button">Delete</button>
                          </div>
                      </div>
                  </div>


                  <div data-bind='visible: showNewDevices' class="col-md-12">
                    <div class="card" style="margin:50px 0">
                          <!-- Default panel contents -->
                          <div class="card-header">New devices</div>
                          <ul class="list-group list-group-flush" style="overflow: auto; height: 15em;">
                            <div data-bind="foreach: newDevices">
                              <li class="list-group-item">
                                  <span data-bind="text: $data.name"></span>
                                  <label class="checkbox">
                                      <input type="checkbox" data-bind="value: id" name="newDevices" />
                                      <span class="success"></span>
                                  </label>
                              </li>
                            </div>
                          </ul>
                          <div class="card-footer">
                            <button class="btn btn-primary" data-bind="click: newDevice" type="button" name="button">Save</button>
                          </div>
                      </div>
                    </div>

            </script>
            <script type="text/html" id ="recordsTemplate">
                <div data-bind="visible: showRec">
                    <p data-bind="text: currentTab"></p>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr data-bind="foreach: currentTabHead">
                                <th data-bind="text: name"></th>
                            </tr>
                        </thead>
                            <tbody data-bind="foreach: $root.currentTabDataRecords" >
                                <tr>
                                    <td class="btn btn-success" data-bind="text: device.name"></td>
                                    <td data-bind="text: temperature"></td>
                                    <td data-bind="text: relative_humidity"></td>
                                    <td data-bind="text: pm2_5"></td>
                                    <td data-bind="text: tvoc"></td>
                                    <td data-bind="text: co2"></td>
                                    <td data-bind="text: co"></td>
                                    <td data-bind="text: air_pressure"></td>
                                    <td data-bind="text: ozone"></td>
                                    <td data-bind="text: no2"></td>
                                </tr>
                            </tbody>
                    </table>
            </div>
        </div>

        <div data-bind='visible: showNewDevices' class="col-md-4">
          <div class="card" style="margin:50px 0">
                <!-- Default panel contents -->
                <div class="card-header">New devices</div>
                <ul class="list-group list-group-flush" style="overflow: auto; height: 15em;">
                  <div data-bind="foreach: newDevices">
                    <li class="list-group-item">
                        <span data-bind="text: $data.name">Some org</span>
                        <label class="checkbox">
                            <input type="checkbox" data-bind="value: id" name="newDevices" />
                            <span class="success"></span>
                        </label>
                    </li>
                  </div>
                </ul>
                <div class="card-footer">
                  <button class="btn btn-primary" data-bind="click: newDevice" type="button" name="button">Save</button>
                </div>
            </div>
        </div>
    </div>
</script>

<script type="text/html" id ="recordsTemplate">
    <div data-bind="visible: showRec">
        <p data-bind="text: currentTab"></p>
        <table class="table table-striped table-bordered">
            <thead>
                <tr data-bind="foreach: currentTabHead">
                    <th data-bind="text: name"></th>
                </tr>
            </thead>
                <tbody data-bind="foreach: $root.currentTabDataRecords" >
                    <tr>
                        <td class="btn btn-success" data-bind="text: device.name"></td>
                        <td data-bind="text: temperature"></td>
                        <td data-bind="text: relative_humidity"></td>
                        <td data-bind="text: pm2_5"></td>
                        <td data-bind="text: tvoc"></td>
                        <td data-bind="text: co2"></td>
                        <td data-bind="text: co"></td>
                        <td data-bind="text: air_pressure"></td>
                        <td data-bind="text: ozone"></td>
                        <td data-bind="text: no2"></td>
                    </tr> 
                </tbody>
        </table>                    
    </div>
</script>

<script type="text/html" id="blueprintPage">
    <select data-bind= "options: blueprintData,
                        optionsText: 'name',
                        value: currentBlueprint,
                        event:{ change:$root.selectFunc}">
    </select>
    <form>
        <input type = "text" id = "changeName">
        <button type = 'button' data-bind="click:changeNameBTN">Change name</button>
    </form>
    <canvas id="currentBP" width="800" height="500"></canvas>

    <form enctype="multipart/form-data" id = "uploadForm">
        <input type="file" id="files" name="" data-bind="event:{change: $root.fileSelect}">
    </form>
    <canvas id="background" width="1000" height="1000" ></canvas>

</script>

<script type="text/html" id="loginPage">
    <div class="text-center" id ="loginCont">
        <h1 class="h3 mb-3 font-weight-normal" data-bind="text: currentPage"></h1>
        <div class="col-md-12 offset-md-4">

                <form class="form-signin" >
                    <div data-bind="foreach: currentPageData">
                        <input class="form-control" required="" data-bind="attr: {type: name, id: name, placeholder: name}">
                    </div>
                    <button class="btn btn-lg btn-primary btn-block"data-bind="click:loginToken, text:loginButton"></button>
                </form>
                      <div class="form-row" data-bind="foreach: pages">
                <div class="col-md-12 mt-2">
                    <a href="#" class="form-control btn btn-info" data-bind="click: $root.choosePage.bind($data, name), text: name"></a>
                </div>
            </div>
            <p class="mt-5 mb-3 text-muted">&copy; 2018 Air Lab</p>
        </div>
    </div>
</script>

<main role="main" class="col-md-12 ml-sm-auto ">
    <div class= 'container-fluid'>
        <div class='row'>
            <div class="col-md-2 bg-light sidebar" data-bind="visible:nav">
                <nav>
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-bind="click: loadModel.bind($data, 'pro')">
                                    <button class="btn btn-info col" type="button"> Profile</button>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#" data-bind="click: loadModel.bind($data, 'dev')">
                                    <button class="btn btn-info col" type="button"> Devices</button>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-bind="click: loadModel.bind($data, 'out')">
                                    <button class="btn btn-danger col" type="button"> Logout</button>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div data-bind="template:currentTemplate"></div>
        </div>
    </div>
</main>

@endsection
