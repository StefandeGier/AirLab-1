@extends('layouts.app')

@section('content')

<div class="container-fluid d-none" id="container">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bind="click: profile">
                            <button class="btn btn-info col" type="button"> {{ __('all.profile') }}</button>
                        </a>
                    </li>
<!--                     <li class="nav-item">
                        <a class="nav-link" href="#">
                            <button class="btn btn-info col" type="button"> Kamers</button>
                        </a>
                    </li> -->

                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bind="click: getDevices">
                            <button class="btn btn-info col" type="button"> {{ __('all.devices') }}</button>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bind="click: getMeters">
                            <button class="btn btn-info col" type="button"> {{ __('all.records') }}</button>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bind="click: logout">
                            <button class="btn btn-danger col" type="button"> {{ __('all.logout') }}</button>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div id="profile" class="info">
            <h2>{{ __('all.profile') }}</h2>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('all.name') }}</th>
                            <th scope="col">{{ __('all.e-mail') }}</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: user">
                        <tr>
                            <td data-bind="text: name"></td>
                            <td data-bind="text: email"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <th></th>
                        <th></th>
                    </tfoot>
                </table>
            </div>        
            </div>

            <h2>{{ __('all.user devices') }} </h2>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('all.name') }}</th>
                            <th scope="col">{{ __('all.mac address') }} </th>
                            <th scope="col">{{ __('all.serial number') }}</th>
                            <th scope="col">{{ __('all.organization') }}</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: userDevice">
                        <tr>
                            <td data-bind="text: name"></td>
                            <td data-bind="text: mac_address"></td>
                            <td data-bind="text: serial_number"></td>
                            <td data-bind="text: organization.name"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tfoot>
                </table>
            </div>  

            <h2>{{ __('all.device records') }}</h2>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('all.device name') }}</th>
                            <th scope="col">{{ __('all.time') }}</th>
                            <th scope="col">{{ __('all.temperature') }}</th>
                            <th scope="col">{{ __('all.relative humidity') }}</th>
                            <th scope="col">{{ __('all.pm2.5') }}</th>
                            <th scope="col">T{{ __('all.tvoc') }}</th>
                            <th scope="col">{{ __('all.co2') }}</th>
                            <th scope="col">{{ __('all.co') }}</th>
                            <th scope="col">{{ __('all.air pressure') }}</th>
                            <th scope="col">{{ __('all.ozone') }}</th>
                            <th scope="col">{{ __('all.no2') }}</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: deviceMeter">
                        <tr>
                            <td data-bind="text: device.name"></td>
                            <td data-bind="text: updated_at"></td>
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
                    <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tfoot>
                </table>
            </div>

            <h2>{{ __('all.last record') }}</h2>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('all.device name') }}</th>
                            <th scope="col">{{ __('all.time') }}</th>
                            <th scope="col">{{ __('all.temperature') }}</th>
                            <th scope="col">{{ __('all.relative humidity') }}</th>
                            <th scope="col">{{ __('all.pm2.5') }}</th>
                            <th scope="col">T{{ __('all.tvoc') }}</th>
                            <th scope="col">{{ __('all.co2') }}</th>
                            <th scope="col">{{ __('all.co') }}</th>
                            <th scope="col">{{ __('all.air pressure') }}</th>
                            <th scope="col">{{ __('all.ozone') }}</th>
                            <th scope="col">{{ __('all.no2') }}</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: meters">
                        <tr>
                            <td data-bind="text: device.name"></td>
                            <td data-bind="text: updated_at"></td>
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
                    <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tfoot>
                </table>
            </div>

            <h2>{{ __('all.devices') }}</h2>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('all.name') }}</th>
                            <th scope="col">{{ __('all.mac address') }}</th>
                            <th scope="col">{{ __('all.serial number') }}</th>
                            <th scope="col">{{ __('all.organization') }}</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: devices">
                        <tr>
                            <td data-bind="text: name"></td>
                            <td data-bind="text: mac_address"></td>
                            <td data-bind="text: serial_number"></td>
                            <td data-bind="text: organization.name"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tfoot>
                </table>
            </div>                
        </main>
    </div>
</div>

<div class="text-center" id ="loginCont">
    <h1 class="h3 mb-3 font-weight-normal" data-bind="text: currentPage"></h1>
    <div class="col-md-4 offset-md-4">

            <form class="form-signin" >
                <div data-bind="foreach: currentPageData">
                    <input class="form-control" required="" data-bind="attr: {type: name, id: name, placeholder: name}">
                </div>
                <button class="btn btn-lg btn-primary btn-block"data-bind="click:loginToken, text:loginButton"></button>
            </form>
                  <div class="form-row" data-bind="foreach: pages">
            <div class="col-md-6 mt-2">
                <a href="#" class="form-control btn btn-info" data-bind="click: $root.choosePage.bind($data, name), text: name"></a>
            </div>
        </div>
        <p class="mt-5 mb-3 text-muted">&copy; 2018 Air Lab</p>

    </div>
</div>
@endsection