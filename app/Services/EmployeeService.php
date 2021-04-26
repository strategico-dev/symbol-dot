<?php


namespace App\Services;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Employee;

class EmployeeService
{
    /**
     * @param Company $company
     * @return mixed
     */
    public static function getByCompany(Company $company)
    {
        return $company->employees()->with('contact')->fetch();
    }

    /**
     * @param Company $company
     * @param Contact $contact
     * @param array $data
     * @return mixed
     */
    public static function create(Company $company, Contact $contact, array $data)
    {
        $data['company_id'] = $company->id;
        $data['contact_id'] = $contact->id;

        return Employee::query()->create($data);
    }

    /**
     * @param Company $company
     * @param $employeeId
     * @return mixed
     * @throws \Exception
     */
    public static function delete(Company $company, $employeeId)
    {
        $employee = $company->employees()->findOrFail($employeeId);
        $employee->delete();

        return $employee;
    }
}
