<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberAccountSummaryAssignUserDateToStartDateField extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\Models\Member::all() as $member) {
            $resObj = DB::table('members_account_summary')
                ->where('member_id', $member->id)
                ->first();

            if (!empty($resObj)) {
                echo 'Updated member ID:'.$member->id.PHP_EOL;
                DB::table('members_account_summary')
                    ->where('member_id', $member->id)
                    ->update(['start_date' => $member->created_at]);
            }
        }
    }
}
