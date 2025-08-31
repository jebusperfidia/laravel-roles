<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Masmerise\Toaster\Toaster;

class UrbanEquipment extends Component
{

    public int $church, $market, $superMarket, $commercialSpaces, $numberCommercialSpaces, $publicSquare, $parks, $gardens,
    $sportsCourts, $sportsCenter, $primarySchool, $middleSchool, $highSchool, $university, $otherNearbySchools,
    $firstLevel, $secondLevel, $thirdLevel, $bank, $communityCenter, $urbanDistance, $urbanFrequency,
    $suburbanDistance, $suburbanFrequency;

    public bool $templeCheckbox = false;
    public bool $marketCheckbox = false;
    public bool $publicSquareCheckbox = false;
    public bool $parkGardensCheckbox = false;
    public bool $schoolsCheckbox = false;
    public bool $hospitalsCheckbox = false;
    public bool $banksCheckbox = false;
    public bool $communityCenterCheckbox = false;
    public bool $transportCheckbox = false;

    public function mount() {
        //Templos
        $this->church = 0;
        //Mercados
        $this->market = 0;
        $this->superMarket = 0;
        $this->commercialSpaces = 0;
        $this->numberCommercialSpaces = 0;
        //Plaza pública
        $this->publicSquare = 0;
        //Parques y jardines
        $this->parks = 0;
        $this->gardens = 0;
        $this->sportsCourts = 0;
        $this->sportsCenter = 0;
        //Escuelas
        $this->primarySchool = 0;
        $this->middleSchool = 0;
        $this->highSchool = 0;
        $this->university = 0;
        $this->otherNearbySchools = 0;
        //Hospitales
        $this->firstLevel = 0;
        $this->secondLevel = 0;
        $this->thirdLevel = 0;
        //Bancos
        $this->bank = 0;
        //Centro comuniatrio
        $this->communityCenter = 0;
        //Transporte
        $this->urbanDistance = 0;
        $this->urbanFrequency = 0;
        $this->suburbanDistance = 0;
        $this->suburbanFrequency = 0;
    }


    //VALORES DE ACTUALIZACIÓN MEDIANTE WATCHERS PARA TEMPLOS
    public function updatedChurch($value) {
        if($value === null){
            $this->church = 0;
        }
        $this->updatedTempleCheckbox();
    }

    public function updatedTempleCheckbox(){
        $this->templeCheckbox = ($this->church > 0);
    }


    //VALORES DE ACTUALIZACIÓN MEDIANTE WATCHERS PARA MERCADOS

    public function updatedMarket($value) {
        if ($value === null) {
            $this->market = 0;
        }
        $this->updatedMarketCheckbox();
    }

    public function updatedSuperMarket($value)
    {
        if ($value === null) {
            $this->superMarket = 0;
        }
        $this->updatedMarketCheckbox();
    }


    public function updatedCommercialSpaces($value)
    {
        if ($value === null) {
            $this->commercialSpaces = 0;
        }
        $this->updatedMarketCheckbox();
    }


    public function updatedNumberCommercialSpaces($value)
    {
        if ($value === null) {
            $this->numberCommercialSpaces = 0;
        }
        $this->updatedMarketCheckbox();
    }


    public function updatedMarketCheckbox()
    {
        $total =   $this->market +  $this->superMarket + $this->commercialSpaces  +  $this->numberCommercialSpaces;

        $this->marketCheckbox = ($total > 0);
    }

    //VALORES DE ACTUALIZACIÓN MEDIANTE WATCHERS PARA PLAZAS PÚBLICAS

    public function updatedPublicSquare($value){
        if ($value === null) {
            $this->publicSquare = 0;
        }
        $this->updatedPublicSquareCheckbox();
    }


    public function updatedPublicSquareCheckbox()
    {
        $this->publicSquareCheckbox = ($this->publicSquare > 0);
    }

    //VALORES DE ACTUALIZACIÓN PARA PARQUES Y JARDINES


    public function updatedParks($value)
    {
        if ($value === null) {
            $this->parks = 0;
        }
        $this->updatedParkGardensCheckbox();
    }

    public function updatedGardens($value)
    {
        if ($value === null) {
            $this->gardens = 0;
        }
        $this->updatedParkGardensCheckbox();
    }

    public function updatedSportsCourts($value)
    {
        if ($value === null) {
            $this->sportsCourts = 0;
        }
        $this->updatedParkGardensCheckbox();
    }

    public function updatedSportsCenter($value)
    {
        if ($value === null) {
            $this->sportsCenter = 0;
        }
        $this->updatedParkGardensCheckbox();
    }



    public function updatedParkGardensCheckbox()
    {
        $total = $this->parks +  $this->gardens + $this->sportsCourts +  $this->sportsCenter;

        $this->parkGardensCheckbox = ($total > 0);
    }



    //VALORES DE ACTUALIZACIÓN PARA ESCUELAS

    public function updatedPrimarySchool($value)
    {
        if ($value === null) {
            $this->primarySchool = 0;
        }
        $this->updatedSchoolsCheckbox();
    }

    public function updatedMiddleSchool($value)
    {
        if ($value === null) {
            $this->middleSchool = 0;
        }
        $this->updatedSchoolsCheckbox();
    }

    public function updatedHighSchool($value)
    {
        if ($value === null) {
            $this->highSchool = 0;
        }
        $this->updatedSchoolsCheckbox();
    }

    public function updatedUniversity($value)
    {
        if ($value === null) {
            $this->university = 0;
        }
        $this->updatedSchoolsCheckbox();
    }

    public function updatedOtherNearbySchools($value)
    {
        if ($value === null) {
            $this->otherNearbySchools = 0;
        }
        $this->updatedSchoolsCheckbox();
    }



    public function updatedSchoolsCheckbox()
    {
        $total =  $this->primarySchool +  $this->middleSchool +  $this->highSchool + $this->university + $this->otherNearbySchools;
        $this->schoolsCheckbox = ($total > 0);
    }



    //VALORES DE ACTUALIZACIÓN PARA HOSPITALES

    public function updatedFirstLevel($value)
    {
        if ($value === null) {
            $this->firstLevel = 0;
        }
        $this->updatedHospitalsCheckbox();
    }


    public function updatedSecondLevel($value)
    {
        if ($value === null) {
            $this->secondLevel = 0;
        }
        $this->updatedHospitalsCheckbox();
    }

    public function updatedThirdLevel($value)
    {
        if ($value === null) {
            $this->thirdLevel = 0;
        }
        $this->updatedHospitalsCheckbox();
    }



    public function updatedHospitalsCheckbox()
    {
        $total =  $this->firstLevel +  $this->secondLevel +  $this->thirdLevel;
        $this->hospitalsCheckbox = ($total > 0);
    }


    //VALORES DE ACTUALIZACIÓN PARA BANCOS

    public function updatedBank($value)
    {
        if ($value === null) {
            $this->bank = 0;
        }
        $this->updatedBanksCheckbox();
    }


    public function updatedBanksCheckbox()
    {
        $this->banksCheckbox = ($this->bank > 0);
    }


    //VALORES DE ACTUALIZACIÓN PARA CENTROS COMUNITARIOS


    public function updatedCommunityCenter($value)
    {
        if ($value === null) {
            $this->communityCenter = 0;
        }
        $this->updatedCommunityCenterCheckbox();
    }


    public function updatedCommunityCenterCheckbox()
    {
        $this->communityCenterCheckbox = ($this->communityCenter > 0);
    }



    //VALORES DE ACTUALIZACIÓN PARA TRANSPORTE
    public function updatedUrbanDistance($value)
    {
        if ($value === null) {
            $this->urbanDistance = 0;
        }
        $this->updatedtransportCheckbox();
    }

    public function updatedUrbanFrequency($value)
    {
        if ($value === null) {
            $this->urbanFrequency = 0;
        }
        $this->updatedtransportCheckbox();
    }

    public function updatedSuburbanDistance($value)
    {
        if ($value === null) {
            $this->suburbanDistance = 0;
        }
        $this->updatedtransportCheckbox();
    }

    public function updatedSuburbanFrequency($value)
    {
        if ($value === null) {
            $this->suburbanFrequency = 0;
        }
        $this->updatedtransportCheckbox();
    }

    public function updatedtransportCheckbox()
    {
        $total = $this->urbanDistance + $this->urbanFrequency + $this->suburbanDistance + $this->suburbanFrequency;
        $this->transportCheckbox = ($total > 0);
    }


    public function save(){
        $rules = [
            'church' => 'required',
            'market' => 'required',
            'superMarket' => 'required',
            'commercialSpaces' => 'required',
            'numberCommercialSpaces' => 'required',
            'publicSquare' => 'required',
            'sportsCourts' => 'required',
            'sportsCenter' => 'required',
            'primarySchool' => 'required',
            'middleSchool' => 'required',
            'highSchool' => 'required',
            'university' => 'required',
            'otherNearbySchools' => 'required',
            'firstLevel' => 'required',
            'secondLevel' => 'required',
            'thirdLevel' => 'required',
            'bank' => 'required',
            'communityCenter' => 'required',
            'urbanDistance' => 'required',
            'urbanFrequency' => 'required',
            'suburbanDistance' => 'required',
            'suburbanFrequency' => 'required'
        ];

        $validator = Validator::make(
            $this->all(),
            $rules,
            [],
            $this->validationAttributes()
        );

        /* dd($validator->errors()); */
        //Comprobamos si se obtuvieron errores de validación
        if ($validator->fails()) {
            //Enviamos un mensaje en pantalla indicando que existen errores de validación
            Toaster::error('Existen errores de validación');

            //Colocamos los errores en pantalla
            $this->setErrorBag($validator->getMessageBag());

            //Hacemos un return para detener el flujo del sistema
            return;
        }

        //
        Toaster::success('Los datos fueron guardados con éxito');
    }



    protected function validationAttributes(): array
    {
        return [
            'church' => ' ',
            'market' => ' ',
            'supermarket' => ' ',
            'commercialSpaces' => ' ',
            'numberCommercialSpaces' => ' ',
            'publicSquare' => ' ',
            'sportsCourts' => ' ',
            'sportsCenter' => ' ',
            'primarySchool' => ' ',
            'middleSchool' => ' ',
            'highSchool' => ' ',
            'university' => ' ',
            'otherNearbySchools' => ' ',
            'firstLevel' => ' ',
            'secondLevel' => ' ',
            'thirdLevel' => ' ',
            'bank' => ' ',
            'communityCenter' => ' ',
            'urbanDistance' => ' ',
            'urbanFrequency' => ' ',
            'suburbanDistance' => ' ',
            'suburbanFrequency' => ' '
        ];
    }

    public function render()
    {
        return view('livewire.forms.urban-equipment');
    }
}
