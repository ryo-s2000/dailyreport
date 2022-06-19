<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'userName' => ['required', 'string', 'max:30'],
            'department_id' => ['required', 'integer', 'max:20'],
            'construction_id' => ['required'],
            'date' => ['required', 'date'],
            'amWeather' => ['string', 'max:20'],
            'pmWeather' => ['string', 'max:20'],
            'constructionNumber' => ['required', 'string', 'max:10'],
            'constructionName' => ['required', 'string', 'max:50'],
            'laborTraderId1' => ['nullable', 'integer'],
            'laborPeopleNumber1' => ['nullable', 'string', 'max:5'],
            'laborWorkTime1' => ['nullable', 'string', 'max:5'],
            'laborWorkVolume1' => ['nullable', 'string', 'max:50'],
            'laborTraderId2' => ['nullable', 'integer'],
            'laborPeopleNumber2' => ['nullable', 'string', 'max:5'],
            'laborWorkTime2' => ['nullable', 'string', 'max:5'],
            'laborWorkVolume2' => ['nullable', 'string', 'max:50'],
            'laborTraderId3' => ['nullable', 'integer'],
            'laborPeopleNumber3' => ['nullable', 'string', 'max:5'],
            'laborWorkTime3' => ['nullable', 'string', 'max:5'],
            'laborWorkVolume3' => ['nullable', 'string', 'max:50'],
            'laborTraderId4' => ['nullable', 'integer'],
            'laborPeopleNumber4' => ['nullable', 'string', 'max:5'],
            'laborWorkTime4' => ['nullable', 'string', 'max:5'],
            'laborWorkVolume4' => ['nullable', 'string', 'max:50'],
            'laborTraderId5' => ['nullable', 'integer'],
            'laborPeopleNumber5' => ['nullable', 'string', 'max:5'],
            'laborWorkTime5' => ['nullable', 'string', 'max:5'],
            'laborWorkVolume5' => ['nullable', 'string', 'max:50'],
            'laborTraderId6' => ['nullable', 'integer'],
            'laborPeopleNumber6' => ['nullable', 'string', 'max:5'],
            'laborWorkTime6' => ['nullable', 'string', 'max:5'],
            'laborWorkVolume6' => ['nullable', 'string', 'max:50'],
            'laborTraderId7' => ['nullable', 'integer'],
            'laborPeopleNumber7' => ['nullable', 'string', 'max:5'],
            'laborWorkTime7' => ['nullable', 'string', 'max:5'],
            'laborWorkVolume7' => ['nullable', 'string', 'max:50'],
            'laborTraderId8' => ['nullable', 'integer'],
            'laborPeopleNumber8' => ['nullable', 'string', 'max:5'],
            'laborWorkTime8' => ['nullable', 'string', 'max:5'],
            'laborWorkVolume8' => ['nullable', 'string', 'max:50'],
            'heavyMachineryTraderId1' => ['nullable', 'integer'],
            'heavyMachineryModel1' => ['nullable', 'integer'],
            'heavyMachineryTime1' => ['nullable', 'integer', 'max:30'],
            'heavyMachineryRemarks1' => ['nullable', 'string', 'max:50'],
            'heavyMachineryTraderId2' => ['nullable', 'integer'],
            'heavyMachineryModel2' => ['nullable', 'integer'],
            'heavyMachineryTime2' => ['nullable', 'integer', 'max:30'],
            'heavyMachineryRemarks2' => ['nullable', 'string', 'max:50'],
            'heavyMachineryTraderId3' => ['nullable', 'integer'],
            'heavyMachineryModel3' => ['nullable', 'integer'],
            'heavyMachineryTime3' => ['nullable', 'integer', 'max:30'],
            'heavyMachineryRemarks3' => ['nullable', 'string', 'max:50'],
            'heavyMachineryTraderId4' => ['nullable', 'integer'],
            'heavyMachineryModel4' => ['nullable', 'integer'],
            'heavyMachineryTime4' => ['nullable', 'integer', 'max:30'],
            'heavyMachineryRemarks4' => ['nullable', 'string', 'max:50'],
            'heavyMachineryTraderId5' => ['nullable', 'integer'],
            'heavyMachineryModel5' => ['nullable', 'integer'],
            'heavyMachineryTime5' => ['nullable', 'integer', 'max:30'],
            'heavyMachineryRemarks5' => ['nullable', 'string', 'max:50'],
            'heavyMachineryTraderId6' => ['nullable', 'integer'],
            'heavyMachineryModel6' => ['nullable', 'integer'],
            'heavyMachineryTime6' => ['nullable', 'integer', 'max:30'],
            'heavyMachineryRemarks6' => ['nullable', 'string', 'max:50'],
            'materialTraderName1' => ['nullable', 'string', 'max:30'],
            'materialName1' => ['nullable', 'string', 'max:50'],
            'materialShapeDimensions1' => ['nullable', 'string', 'max:50'],
            'materialQuantity1' => ['nullable', 'string', 'max:10'],
            'materialUnit1' => ['nullable', 'string', 'max:10'],
            'materialResult1' => ['nullable', 'string', 'max:10'],
            'materialInspectionMethods1' => ['nullable', 'string', 'max:50'],
            'materialInspector1' => ['nullable', 'string', 'max:20'],
            'materialTraderName2' => ['nullable', 'string', 'max:30'],
            'materialName2' => ['nullable', 'string', 'max:50'],
            'materialShapeDimensions2' => ['nullable', 'string', 'max:50'],
            'materialQuantity2' => ['nullable', 'string', 'max:10'],
            'materialUnit2' => ['nullable', 'string', 'max:10'],
            'materialResult2' => ['nullable', 'string', 'max:10'],
            'materialInspectionMethods2' => ['nullable', 'string', 'max:50'],
            'materialInspector2' => ['nullable', 'string', 'max:20'],
            'materialTraderName3' => ['nullable', 'string', 'max:30'],
            'materialName3' => ['nullable', 'string', 'max:50'],
            'materialShapeDimensions3' => ['nullable', 'string', 'max:50'],
            'materialQuantity3' => ['nullable', 'string', 'max:10'],
            'materialUnit3' => ['nullable', 'string', 'max:10'],
            'materialResult3' => ['nullable', 'string', 'max:10'],
            'materialInspectionMethods3' => ['nullable', 'string', 'max:50'],
            'materialInspector3' => ['nullable', 'string', 'max:20'],
            'materialTraderName4' => ['nullable', 'string', 'max:30'],
            'materialName4' => ['nullable', 'string', 'max:50'],
            'materialShapeDimensions4' => ['nullable', 'string', 'max:50'],
            'materialQuantity4' => ['nullable', 'string', 'max:10'],
            'materialUnit4' => ['nullable', 'string', 'max:10'],
            'materialResult4' => ['nullable', 'string', 'max:10'],
            'materialInspectionMethods4' => ['nullable', 'string', 'max:50'],
            'materialInspector4' => ['nullable', 'string', 'max:20'],
            'materialTraderName5' => ['nullable', 'string', 'max:30'],
            'materialName5' => ['nullable', 'string', 'max:50'],
            'materialShapeDimensions5' => ['nullable', 'string', 'max:50'],
            'materialQuantity5' => ['nullable', 'string', 'max:10'],
            'materialUnit5' => ['nullable', 'string', 'max:10'],
            'materialResult5' => ['nullable', 'string', 'max:10'],
            'materialInspectionMethods5' => ['nullable', 'string', 'max:50'],
            'materialInspector5' => ['nullable', 'string', 'max:20'],
            'processName1' => ['nullable', 'string', 'max:50'],
            'processLocation1' => ['nullable', 'string', 'max:50'],
            'processMethods1' => ['nullable', 'string', 'max:50'],
            'processDocument1' => ['nullable', 'string', 'max:50'],
            'processResult1' => ['nullable', 'string', 'max:10'],
            'processInspector1' => ['nullable', 'string', 'max:20'],
            'processName2' => ['nullable', 'string', 'max:50'],
            'processLocation2' => ['nullable', 'string', 'max:50'],
            'processMethods2' => ['nullable', 'string', 'max:50'],
            'processDocument2' => ['nullable', 'string', 'max:50'],
            'processResult2' => ['nullable', 'string', 'max:10'],
            'processInspector2' => ['nullable', 'string', 'max:20'],
            'processName3' => ['nullable', 'string', 'max:50'],
            'processLocation3' => ['nullable', 'string', 'max:50'],
            'processMethods3' => ['nullable', 'string', 'max:50'],
            'processDocument3' => ['nullable', 'string', 'max:50'],
            'processResult3' => ['nullable', 'string', 'max:10'],
            'processInspector3' => ['nullable', 'string', 'max:20'],
            'processName4' => ['nullable', 'string', 'max:50'],
            'processLocation4' => ['nullable', 'string', 'max:50'],
            'processMethods4' => ['nullable', 'string', 'max:50'],
            'processDocument4' => ['nullable', 'string', 'max:50'],
            'processResult4' => ['nullable', 'string', 'max:10'],
            'processInspector4' => ['nullable', 'string', 'max:20'],
            'measuringEquipmentName1' => ['nullable', 'string', 'max:50'],
            'measuringEquipmentNumber1' => ['nullable', 'string', 'max:20'],
            'measuringEquipmentResult1' => ['nullable', 'string', 'max:10'],
            'measuringEquipmentRemarks1' => ['nullable', 'string', 'max:50'],
            'measuringEquipmentName2' => ['nullable', 'string', 'max:50'],
            'measuringEquipmentNumber2' => ['nullable', 'string', 'max:20'],
            'measuringEquipmentResult2' => ['nullable', 'string', 'max:10'],
            'measuringEquipmentRemarks2' => ['nullable', 'string', 'max:50'],
            'patrolResult' => ['string', 'max:10'],
            'patrolFindings' => ['nullable', 'string', 'max:500'],
            'transition-preview' => ['string'],
        ];
    }

    public function dailyreportAttributes(): array
    {
        return $this->only([
            'userName',
            'department_id',
            'construction_id',
            'date',
            'amWeather',
            'pmWeather',
            'constructionNumber',
            'constructionName',
            'laborTraderId1',
            'laborPeopleNumber1',
            'laborWorkTime1',
            'laborWorkVolume1',
            'laborTraderId2',
            'laborPeopleNumber2',
            'laborWorkTime2',
            'laborWorkVolume2',
            'laborTraderId3',
            'laborPeopleNumber3',
            'laborWorkTime3',
            'laborWorkVolume3',
            'laborTraderId4',
            'laborPeopleNumber4',
            'laborWorkTime4',
            'laborWorkVolume4',
            'laborTraderId5',
            'laborPeopleNumber5',
            'laborWorkTime5',
            'laborWorkVolume5',
            'laborTraderId6',
            'laborPeopleNumber6',
            'laborWorkTime6',
            'laborWorkVolume6',
            'laborTraderId7',
            'laborPeopleNumber7',
            'laborWorkTime7',
            'laborWorkVolume7',
            'laborTraderId8',
            'laborPeopleNumber8',
            'laborWorkTime8',
            'laborWorkVolume8',
            'heavyMachineryTraderId1',
            'heavyMachineryModel1',
            'heavyMachineryTime1',
            'heavyMachineryRemarks1',
            'heavyMachineryTraderId2',
            'heavyMachineryModel2',
            'heavyMachineryTime2',
            'heavyMachineryRemarks2',
            'heavyMachineryTraderId3',
            'heavyMachineryModel3',
            'heavyMachineryTime3',
            'heavyMachineryRemarks3',
            'heavyMachineryTraderId4',
            'heavyMachineryModel4',
            'heavyMachineryTime4',
            'heavyMachineryRemarks4',
            'heavyMachineryTraderId5',
            'heavyMachineryModel5',
            'heavyMachineryTime5',
            'heavyMachineryRemarks5',
            'heavyMachineryTraderId6',
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
            'transition-preview',
            'updated_at',
        ]);
    }
}
