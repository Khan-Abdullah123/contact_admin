<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;


class BulkController extends Controller
{
/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //

    }


    public function BulkInsert(Request $req)
    {
        $requestData = json_decode($req->getContent(), true);
        $data = $requestData['excelRows'] ?? null;

        if (!$data || !is_array($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data format.'
            ]);
        }

        $insertData = [];
        $duplicateMessages = [];
        $duplicateCount = 0;
        $insertCount = 0;

        $phones = array_column($data, 4);
        $emails = array_column($data, 3);

        $existingContacts = DB::table('contact')
            ->whereIn('phone', array_filter($phones))
            ->orWhereIn('email', array_filter($emails))
            ->get(['phone', 'email'])
            ->keyBy(function ($item) {
                return strtolower($item->phone) . '-' . strtolower($item->email);
            });

        foreach ($data as $item) {
            $phone = strtolower($item[4] ?? '');
            $email = strtolower($item[3] ?? '');

            $key = $phone . '-' . $email;

            if ($existingContacts->has($key)) {
                $duplicateMessages[] = [
                    'phone' => $item[4],
                    'email' => $item[3],
                    'message' => "Phone number '{$item[4]}' or email '{$item[3]}' is already registered."
                ];
                $duplicateCount++;
                continue;
            }

            $insertData[] = [
                'name' => $item[0] ?? null,
                'gender' => $item[1] ?? null,
                'capacity' => $item[2] ?? null,
                'email' => $item[3] ?? null,
                'phone' => $item[4] ?? null,
                'experties' => $item[5] ?? null,
                'address' => $item[6] ?? null,
                'tag' => $item[7] ?? null,
            ];
            $insertCount++;
        }

        $totalCount = $insertCount + $duplicateCount;

        if ($insertCount > 0) {
            DB::table('contact')->insert($insertData);
            return response()->json([
                'success' => true,
                'message' => "{$insertCount} records were inserted out of {$totalCount}.",
                'duplicates' => $duplicateMessages,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "{$duplicateCount} duplicate records found.",
            'duplicates' => $duplicateMessages,
        ]);

    }




    public function BulkDelete(Request $req)
    {

        if ($req->has('contact_id')) {
            DB::table('contact')->whereIn("contact_id", $req->input('contact_id'))->delete();
            return response()->json(["success" => true, "message" => "Selected contacts deleted successfully"]);
        }
        return response()->json(["success" => false, "message" => "No contacts selected"]);
    }


}
