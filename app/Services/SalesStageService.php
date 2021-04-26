<?php


namespace App\Services;

use App\Models\Contact;
use App\Models\SalesStage;
use App\Models\SalesFunnel;
use Illuminate\Support\Facades\DB;

class SalesStageService
{
    /**
     * @param SalesFunnel $salesFunnel
     * @return mixed
     */
    public static function getWithPagination(SalesFunnel $salesFunnel)
    {
        return $salesFunnel->salesStages()->
                             with('contacts')->
                             orderBy('order', 'ASC')->
                             get();
    }

    /**
     * @param SalesFunnel $salesFunnel
     * @param array $data
     * @return mixed
     */
    public static function create(SalesFunnel $salesFunnel, array $data)
    {
        return $salesFunnel->salesStages()->save(new SalesStage($data));
    }

    /**
     * @param SalesFunnel $salesFunnel
     * @param $salesStageId
     * @return mixed
     * @throws \Exception
     */
    public static function delete(SalesFunnel $salesFunnel, $salesStageId)
    {
        $salesStage = $salesFunnel->salesStages()->findOrFail($salesStageId);

        $salesStage->delete();
        return $salesStage;
    }

    /**
     * @param SalesFunnel $salesFunnel
     * @param Contact $contact
     * @param $stageId
     * @return Contact
     */
    public static function addContact(SalesFunnel $salesFunnel, Contact $contact, $stageId)
    {
        /* @var SalesStage $salesStage */
        $salesStage = $salesFunnel->salesStages()->findOrFail($stageId);
        $salesStage->contacts()->attach($contact);

        return $contact;
    }

    /**
     * @param SalesFunnel $salesFunnel
     * @param Contact $contact
     * @param $currentStageId
     * @param $targetStageId
     * TODO: Refactoring
     */
    public static function changeSalesStage(
        SalesFunnel $salesFunnel,
        Contact $contact,
        $currentStageId,
        $targetStageId
    )
    {
        /* @var SalesStage $currentStage */
        $currentStage = $salesFunnel->salesStages()->findOrFail($currentStageId);
        /* @var SalesStage $targetStage */
        $targetStage = $salesFunnel->salesStages()->findOrFail($targetStageId);

        DB::transaction(function () use ($currentStage, $targetStage, $contact) {
            $currentStage->contacts()->detach($contact);
            $targetStage->contacts()->attach($contact);
        });
    }

    /**
     * @param SalesFunnel $salesFunnel
     * @param Contact $contact
     * @param $stageId
     */
    public static function deleteContact(SalesFunnel $salesFunnel, Contact $contact, $stageId)
    {
        /* @var SalesStage $salesStage */
        $salesStage = $salesFunnel->salesStages()->findOrFail($stageId);

        $salesStage->contacts()->detach($contact);
    }


    /**
     * @param SalesFunnel $salesFunnel
     * @param $currentStageId
     * @param $targetStageId
     */
    public static function swapPositions(SalesFunnel $salesFunnel, $currentStageId, $targetStageId)
    {
        /* @var SalesStage $currentStage */
        $currentStage = $salesFunnel->salesStages()->findOrFail($currentStageId);
        /* @var SalesStage $targetStage */
        $targetStage = $salesFunnel->salesStages()->findOrFail($targetStageId);

        $currentStagePosition = $currentStage->position;
        $currentStage->position = $targetStage->position;
        $targetStage->position = $currentStagePosition;

        DB::transaction(function () use ($currentStage, $targetStage) {
            $currentStage->save();
            $targetStage->save();
        });
    }
}
