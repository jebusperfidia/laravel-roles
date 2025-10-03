<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Masmerise\Toaster\Toaster;
use App\Models\Forms\UrbanEquipment\UrbanEquipmentModel;

class UrbanEquipment extends Component
{
    public $valuation_id;

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

    public function mount()
    {

        $valuationId = session('valuation_id');
        // Guardar el valuationId en una propiedad pública
        $this->valuation_id = $valuationId;

        // Asignar el modelo solo si valuationId existe para evitar errores
        $urbanEquipment = UrbanEquipmentModel::where('valuation_id', $valuationId)->first();


        if ($urbanEquipment) {

            //Templos
            $this->church = $urbanEquipment->church;
            //Mercados
            $this->market = $urbanEquipment->market;
            $this->superMarket = $urbanEquipment->super_market;
            $this->commercialSpaces = $urbanEquipment->commercial_spaces;
            $this->numberCommercialSpaces = $urbanEquipment->number_commercial_spaces;
            //Plaza pública
            $this->publicSquare = $urbanEquipment->public_square;
            //Parques y jardines
            $this->parks = $urbanEquipment->parks;
            $this->gardens = $urbanEquipment->gardens;
            $this->sportsCourts = $urbanEquipment->sports_courts;
            $this->sportsCenter = $urbanEquipment->sports_center;
            //Escuelas
            $this->primarySchool = $urbanEquipment->primary_school;
            $this->middleSchool = $urbanEquipment->middle_school;
            $this->highSchool = $urbanEquipment->high_school;
            $this->university = $urbanEquipment->university;
            $this->otherNearbySchools = $urbanEquipment->other_nearby_schools;
            //Hospitales
            $this->firstLevel = $urbanEquipment->first_level;
            $this->secondLevel = $urbanEquipment->second_level;
            $this->thirdLevel = $urbanEquipment->third_level;
            //Bancos
            $this->bank = $urbanEquipment->bank;
            //Centro comuniatrio
            $this->communityCenter = $urbanEquipment->community_center;
            //Transporte
            $this->urbanDistance = $urbanEquipment->urban_distance;
            $this->urbanFrequency = $urbanEquipment->urban_frequency;
            $this->suburbanDistance = $urbanEquipment->suburban_distance;
            $this->suburbanFrequency = $urbanEquipment->suburban_frequency;
        } else {


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

        $this->updatedTempleCheckbox();
        $this->updatedMarketCheckbox();
        $this->updatedPublicSquareCheckbox();
        $this->updatedParkGardensCheckbox();
        $this->updatedSchoolsCheckbox();
        $this->updatedHospitalsCheckbox();
        $this->updatedBanksCheckbox();
        $this->updatedCommunityCenterCheckbox();
        $this->updatedtransportCheckbox();
    }

    public function save()
    {
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

        // Mapea las propiedades del componente a un array con nombres de columnas de la DB
        $data = [
            'church' => $this->church,
            'market' => $this->market,
            'super_market' => $this->superMarket,
            'commercial_spaces' => $this->commercialSpaces,
            'number_commercial_spaces' => $this->numberCommercialSpaces,
            'public_square' =>$this->publicSquare,
            'parks' => $this->parks,
            'gardens' => $this->gardens,
            'sports_courts' => $this->sportsCourts,
            'sports_center' => $this->sportsCenter,
            'primary_school' => $this->primarySchool,
            'middle_school' => $this->middleSchool,
            'high_school' => $this->highSchool,
            'university' => $this->university,
            'other_nearby_schools' => $this->otherNearbySchools,
            'first_level' => $this->firstLevel,
            'second_level' => $this->secondLevel,
            'third_level' => $this->thirdLevel,
            'bank' => $this->bank,
            'community_center' => $this->communityCenter,
            'urban_distance' => $this->urbanDistance,
            'urban_frequency' => $this->urbanFrequency,
            'suburban_distance' => $this->suburbanDistance,
            'suburban_frequency' => $this->suburbanFrequency
        ];

        //dd($data);

        // Guardar o actualizar
        UrbanEquipmentModel::updateOrCreate(
            ['valuation_id' => $this->valuation_id],
            $data
        );



        Toaster::success('Formulario guardado con éxito');
        return redirect()->route('form.index', ['section' => 'land-details']);
    }



    private function sanitizeInteger($value): int
    {
        // Si el valor es nulo o una cadena vacía, se retorna 0
        if ($value === null || trim((string)$value) === '') {
            return 0;
        }

        // Elimina cualquier carácter que no sea un número
        // Esto remueve signos +, - y otros símbolos no numéricos
        $clean = preg_replace('/[^0-9]/', '', (string)$value);

        // Convierte el resultado a entero
        return (int) $clean;
    }


    //VALORES DE ACTUALIZACIÓN MEDIANTE WATCHERS PARA TEMPLOS
    public function updatedChurch($value) {
      /*   if($value === null){
            $this->church = 0;
        } */
        $this->church = $this->sanitizeInteger($value);
        $this->updatedTempleCheckbox();
    }

    public function updatedTempleCheckbox(){
        $this->templeCheckbox = ($this->church > 0);
    }


    //VALORES DE ACTUALIZACIÓN MEDIANTE WATCHERS PARA MERCADOS

    public function updatedMarket($value) {
        $this->market = $this->sanitizeInteger($value);
        $this->updatedMarketCheckbox();
    }

    public function updatedSuperMarket($value)
    {
        $this->superMarket = $this->sanitizeInteger($value);
        $this->updatedMarketCheckbox();
    }


    public function updatedCommercialSpaces($value)
    {
        $this->commercialSpaces = $this->sanitizeInteger($value);
        $this->updatedMarketCheckbox();
    }


    public function updatedNumberCommercialSpaces($value)
    {
        $this->numberCommercialSpaces = $this->sanitizeInteger($value);
        $this->updatedMarketCheckbox();
    }


    public function updatedMarketCheckbox()
    {
        $total =   $this->market +  $this->superMarket + $this->commercialSpaces  +  $this->numberCommercialSpaces;

        $this->marketCheckbox = ($total > 0);
    }

    //VALORES DE ACTUALIZACIÓN MEDIANTE WATCHERS PARA PLAZAS PÚBLICAS

    public function updatedPublicSquare($value){
        $this->publicSquare = $this->sanitizeInteger($value);
        $this->updatedPublicSquareCheckbox();
    }


    public function updatedPublicSquareCheckbox()
    {
        $this->publicSquareCheckbox = ($this->publicSquare > 0);
    }

    //VALORES DE ACTUALIZACIÓN PARA PARQUES Y JARDINES


    public function updatedParks($value)
    {
        $this->parks = $this->sanitizeInteger($value);
        $this->updatedParkGardensCheckbox();
    }

    public function updatedGardens($value)
    {
        $this->gardens = $this->sanitizeInteger($value);
        $this->updatedParkGardensCheckbox();
    }

    public function updatedSportsCourts($value)
    {
        $this->sportsCourts = $this->sanitizeInteger($value);
        $this->updatedParkGardensCheckbox();
    }

    public function updatedSportsCenter($value)
    {
        $this->sportsCenter = $this->sanitizeInteger($value);
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
        $this->primarySchool = $this->sanitizeInteger($value);
        $this->updatedSchoolsCheckbox();
    }

    public function updatedMiddleSchool($value)
    {
        $this->middleSchool = $this->sanitizeInteger($value);
        $this->updatedSchoolsCheckbox();
    }

    public function updatedHighSchool($value)
    {
        $this->highSchool = $this->sanitizeInteger($value);
        $this->updatedSchoolsCheckbox();
    }

    public function updatedUniversity($value)
    {
        $this->university = $this->sanitizeInteger($value);
        $this->updatedSchoolsCheckbox();
    }

    public function updatedOtherNearbySchools($value)
    {
        $this->otherNearbySchools = $this->sanitizeInteger($value);
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
        $this->firstLevel = $this->sanitizeInteger($value);
        $this->updatedHospitalsCheckbox();
    }


    public function updatedSecondLevel($value)
    {
        $this->secondLevel = $this->sanitizeInteger($value);
        $this->updatedHospitalsCheckbox();
    }

    public function updatedThirdLevel($value)
    {
        $this->thirdLevel = $this->sanitizeInteger($value);
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
        $this->bank = $this->sanitizeInteger($value);
        $this->updatedBanksCheckbox();
    }


    public function updatedBanksCheckbox()
    {
        $this->banksCheckbox = ($this->bank > 0);
    }


    //VALORES DE ACTUALIZACIÓN PARA CENTROS COMUNITARIOS


    public function updatedCommunityCenter($value)
    {
        $this->communityCenter = $this->sanitizeInteger($value);
        $this->updatedCommunityCenterCheckbox();
    }


    public function updatedCommunityCenterCheckbox()
    {
        $this->communityCenterCheckbox = ($this->communityCenter > 0);
    }



    //VALORES DE ACTUALIZACIÓN PARA TRANSPORTE
    public function updatedUrbanDistance($value)
    {
        $this->urbanDistance = $this->sanitizeInteger($value);
        $this->updatedtransportCheckbox();
    }

    public function updatedUrbanFrequency($value)
    {
        $this->urbanFrequency = $this->sanitizeInteger($value);
        $this->updatedtransportCheckbox();
    }

    public function updatedSuburbanDistance($value)
    {
        $this->suburbanDistance = $this->sanitizeInteger($value);
        $this->updatedtransportCheckbox();
    }

    public function updatedSuburbanFrequency($value)
    {
        $this->suburbanFrequency = $this->sanitizeInteger($value);
        $this->updatedtransportCheckbox();
    }

    public function updatedtransportCheckbox()
    {
        $total = $this->urbanDistance + $this->urbanFrequency + $this->suburbanDistance + $this->suburbanFrequency;
        $this->transportCheckbox = ($total > 0);
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
