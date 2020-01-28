<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailyreportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // ここでバリデーションをかけられるらしい
        ];
    }

    public function dailyreportAttributes()
    {
        return $this->only([
            'id',
            'userName',
            'department',
            'date',
            'amWeather',
            'pmWeather',
            'constructionNumber',
            'constructionName',
            'laborTraderName1',
            'laborPeopleNumber1',
            'laborWorkTime1',
            'laborWorkVolume1',
            'laborTraderName2',
            'laborPeopleNumber2',
            'laborWorkTime2',
            'laborWorkVolume2',
            'laborTraderName3',
            'laborPeopleNumber3',
            'laborWorkTime3',
            'laborWorkVolume3',
            'laborTraderName4',
            'laborPeopleNumber4',
            'laborWorkTime4',
            'laborWorkVolume4',
            'laborTraderName5',
            'laborPeopleNumber5',
            'laborWorkTime5',
            'laborWorkVolume5',
            'laborTraderName6',
            'laborPeopleNumber6',
            'laborWorkTime6',
            'laborWorkVolume6',
            'laborTraderName7',
            'laborPeopleNumber7',
            'laborWorkTime7',
            'laborWorkVolume7',
            'laborTraderName8',
            'laborPeopleNumber8',
            'laborWorkTime8',
            'laborWorkVolume8',
            'heavyMachineryTraderName1',
            'heavyMachineryModel1',
            'heavyMachineryTime1',
            'heavyMachineryRemarks1',
            'heavyMachineryTraderName2',
            'heavyMachineryModel2',
            'heavyMachineryTime2',
            'heavyMachineryRemarks2',
            'heavyMachineryTraderName3',
            'heavyMachineryModel3',
            'heavyMachineryTime3',
            'heavyMachineryRemarks3',
            'heavyMachineryTraderName4',
            'heavyMachineryModel4',
            'heavyMachineryTime4',
            'heavyMachineryRemarks4',
            'heavyMachineryTraderName5',
            'heavyMachineryModel5',
            'heavyMachineryTime5',
            'heavyMachineryRemarks5',
            'heavyMachineryTraderName6',
            'heavyMachineryModel6',
            'heavyMachineryTime6',
            'heavyMachineryRemarks6',
            'materialTraderName1',
            'materialName1',
            'materialShapeDimensions1',
            'materialQuantity1',
            'materialUnit1',
            'materialResult1',
            'materialInspectionMethods1',
            'materialInspector1',
            'materialTraderName2',
            'materialName2',
            'materialShapeDimensions2',
            'materialQuantity2',
            'materialUnit2',
            'materialResult2',
            'materialInspectionMethods2',
            'materialInspector2',
            'materialTraderName3',
            'materialName3',
            'materialShapeDimensions3',
            'materialQuantity3',
            'materialUnit3',
            'materialResult3',
            'materialInspectionMethods3',
            'materialInspector3',
            'materialTraderName4',
            'materialName4',
            'materialShapeDimensions4',
            'materialQuantity4',
            'materialUnit4',
            'materialResult4',
            'materialInspectionMethods4',
            'materialInspector4',
            'materialTraderName5',
            'materialName5',
            'materialShapeDimensions5',
            'materialQuantity5',
            'materialUnit5',
            'materialResult5',
            'materialInspectionMethods5',
            'materialInspector5',
            'processName1',
            'processLocation1',
            'processMethods1',
            'processDocument1',
            'processResult1',
            'processInspector1',
            'processName2',
            'processLocation2',
            'processMethods2',
            'processDocument2',
            'processResult2',
            'processInspector2',
            'processName3',
            'processLocation3',
            'processMethods3',
            'processDocument3',
            'processResult3',
            'processInspector3',
            'processName4',
            'processLocation4',
            'processMethods4',
            'processDocument4',
            'processResult4',
            'processInspector4',
            'measuringEquipmentName1',
            'measuringEquipmentNumber1',
            'measuringEquipmentResult1',
            'measuringEquipmentRemarks1',
            'measuringEquipmentName2',
            'measuringEquipmentNumber2',
            'measuringEquipmentResult2',
            'measuringEquipmentRemarks2',
            'patrolResult',
            'patrolFindings',
            'updated_at'
        ]);
    }
}
