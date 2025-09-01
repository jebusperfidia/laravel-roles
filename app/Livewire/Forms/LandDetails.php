<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class LandDetails extends Component
{

    //PRIMER CONTENEDOR
    public $sli_sourceLegalInformation;
    //Variables select escritura
    public $sli_notaryOfficeDeed, $sli_deedDeed, $sli_volumeDeed, $sli_dateDeed, $sli_notaryDeed, $sli_judicialDistricDeed;
    //Variables select sentencia
    public $sli_fileJudgment, $sli_dateJudgment, $sli_courtJudgment, $sli_municipalityJudgment;
    //Variables select contrato privado
    public $sli_datePrivCont, $sli_namePrivContAcq, $sli_firstNamePrivContAcq, $sli_secondNamePrivContAcq,
        $sli_namePrivContAlt, $sli_firstNamePrivContAlt, $sli_secondNamePrivContAlt;
    //Variante select alineamiento y numero oficial
    public $sli_folioAon, $sli_dateAon, $sli_municipalityAon;
    //Variante select título de propiedad
    public $sli_recordPropReg, $sli_datePropReg, $sli_instrumentPropReg, $sli_placePropReg;
    //Variante select otra fuente de informacion legal
    public $sli_especifyAsli, $sli_dateAsli, $sli_emittedByAsli, $sli_folioAsli;

    public function render()
    {
        return view('livewire.forms.land-details');
    }
}
