<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Record;
use App\Device;
use App\Organization;
use App\User;
use Carbon\Carbon;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    /**
     * Display record details
     * 
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function recordDetail()
    {

        $id = request('id');

        $device = Device::findOrFail($id);
        //->orderBy('id', 'desc')->first()
        $record = Record::where('device_id', '=', $device->id)->first();

        // return response()->json($record);
        return $record;
    }

    /**
     * Display all devices
     *
     * [deviceView description]
     * @return [type] [description]
     */
    // START STEFAN CODE
    public function getOrganizations()
    {

      $organizations = Organization::all();

      return $organizations;
    }
    /**
     * Display all devices from organization
     *
     * [deviceView description]
     * @return [type] [description]
     */
    public function getDevicesOrganization(Request $request)
    {

      if ($request->id) {
        $orgDevices = Device::where('organization_id', $request->id)->get();
      }
        return $orgDevices;
    }
    /**
     * Display all devices with no organization
     *
     * [deviceView description]
     * @return [type] [description]
     */
    public function getNewDevices()
    {
      $cleanDevices = Device::where('organization_id', NULL)->get();
      return $cleanDevices;
    }
    /**
     * Display
     *
     * [deviceView description]
     * @return [type] [description]
     */
    public function addDeviceOrg(Request $request)
    {
      $status = 0;
      foreach ($request->device_id as $id) {
        Device::where('id', $id)->update(['organization_id' => $request->organization_id]);
        $status = 1;
      }
      return $status;
    }
    /**
     * Display
     *
     * [deviceView description]
     * @return [type] [description]
     */
    public function deleteDevicesOrganization(Request $request)
    {
      $status = 0;
      foreach ($request->device_id as $id) {
        Device::where('id', $id)->update(['organization_id' => NULL]);
        //softdelete concept
        //Device::where('id', $id)->delete();
        $status = 1;
      }
      return $status;
    }
    // END STEFAN CODE
    /**
     * Display all devices
     *
     * [deviceView description]
     * @return [type] [description]
     */
    /*
    public function deviceView()
    {
        $devices = Device::all();

        foreach ($devices as $device) {
          if ($device->organization_id == true) {
            $device->organization;
          }else {
            $device->organization_name = 'none';
          }
        }
        return $devices;
    }
    */
    /**
     * Display all records that belongs to logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function recordView(){
        $records = Record::all();
        $devices = Device::all();
        $organizations = Organization::all();
        $user = AuthController::me();
        $content = $user->getContent();
        $userInfo = json_decode($content, true);
        $recordray = array();
        $users = User::all();
        // $user = User::with('organization_id')->get();

        // $categories = Category::with(['posts' => function ($query) {
        //     $query->orderBy('created_at', 'desc')->take(5);
        // }])->get();

        // $devices = Device::where($user == 'organization_id')->get();

        // $records = Meter::where($devices == 'device_id')->get();

        // $recordray[] = $records;

        // return $recordray;

        foreach ($organizations as $organization) {
            //$userInfo['name']
            foreach ($users as $user) {
                if ($userInfo['name'] == $organization->name) {
                    foreach ($devices as $device) {
                        if ($device->organization_id == $organization->id) {
                            foreach ($records as $record) {
                                $record->device_name = $record->device->name;
                                // $record->device->serial_number;
                                if ($record->device_name == $device->name) {
                                    $recordray[] = $record;
                                    // $record;
                                    // $data = json_encode($recordray);
                                }
                            }
                        }
                    }
                } 
            }  
        }
        return $recordray;
    }

    /**
     * Method to get all devices that belongs to logged in user
     * [userDevice description]
     * @return [type] [description]
     */
    public function userDevice()
    {
        $devices = Device::all();
        $records = Record::all();
        $organizations = Organization::all();
        $user = AuthController::me();
        $content = $user->getContent();
        $userInfo = json_decode($content, true);
        $userDevice = array();

        // $user = User::with('organization_id')->get();
        // $devices = Device::where($user->organization_id == 'organization_id')->get();
        // $userDevice[] = $devices;
        // return $userDevice;
        
        foreach ($organizations as $organization) {
            if ($userInfo['name'] == $organization->name) {
                foreach ($devices as $device) {
                    $device->records;
                    if ($organization->name == $device->organization->name) {
                        $userDevice[] = $device;
                    }
                }
            }
        }

        return $userDevice;
    }

    /**
     * Method for getting a list of all available devices.
     *
     * [getUhooData description]
     * @return [type] [description]
     * @return \Illuminate\Http\Response
     */
    public function getUhooDevices()
    {
        $data = array('username' => 'uhoo@theinnoventors.eu', 'password' => '3e24510760d65ee46ba631e4d2d2d04bb1f86fecf56ee2e1248dc59b6749be6e');

        // Receive API by doing an 'POST' request
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.uhooinc.com/v1/getdevicelist");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_exec($curl);

        $result = curl_exec($curl);
        $response = json_decode($result);

        $devices = Device::all();
        $organizations = Organization::all();
        $user = AuthController::me();
        $content = $user->getContent();
        $userInfo = json_decode($content, true);

        foreach ($response as $res) {
            foreach ($devices as $device) {
                if ($res->deviceName !== $device->name) {
                    dd('not iden');
                    //Save new devices to DB
                    $device = new Device;
                    $device->name = $res->deviceName;
                    $device->mac_address = $res->macAddress;
                    $device->serial_number = $res->serialNumber;
                    foreach ($organizations as $organization) {
                        if ($userInfo['name'] == $organization->name) {
                            $device->organization_id = $organization->id;
                        }
                    }
                    // $device->save();
                }
            }
        }

        // Redirect to devices page
        return redirect('api/uhoo/devices');
    }

    /**
     * Method for getting a data per minute.
     *
     * [getUhooData description]
     * @return [type] [description]
     * @return \Illuminate\Http\Response
     */
    public function getUhooData()
    {
        $data = array('username' => 'uhoo@theinnoventors.eu', 'password' => '3e24510760d65ee46ba631e4d2d2d04bb1f86fecf56ee2e1248dc59b6749be6e', 'serialNumber' => '52ff6e067565555639500367');

        // Receive API by doing an 'POST' request
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.uhooinc.com/v1/getlatestdata");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_exec($curl);

        $result = curl_exec($curl);
        $response = json_decode($result);

        $devices = Device::all();

        // Save new records data to DB
        $record = new Record;
        foreach ($devices as $device) {
            if ($device->serial_number == $data['serialNumber']) {
                $record->device_id = $device->id;
            }
        }
        $record->temperature = $response->Temperature;
        $record->relative_humidity = $response->{'Relative Humidity'};
        $record->pm2_5 = $response->{'PM2.5'};
        $record->tvoc = $response->TVOC;
        $record->co2 = $response->CO2;
        $record->co = $response->CO;
        $record->air_pressure = $response->{'Air Pressure'};
        $record->ozone = $response->Ozone;
        $record->no2 = $response->NO2; 
        // $record->save();

        // Redirect to records page
        return redirect('api/uhoo/records');
    }
}
