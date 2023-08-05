<?php

namespace Database\Seeders;

use App\Models\Contractor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ybazli\Faker\Facades\Faker;

class ContractorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 5; $i++) {
            $ContName=Faker::word();
            $cont = new Contractor();
            $cont->ContCode = '7000'+$i;
            $cont->ContName = $ContName;
            $cont->ManagerName = Faker::firstName();
            $cont->ManagerFamily = Faker::lastName();
            $cont->ManagerPhone = 025165423142;
            $cont->ManagerMobile = Faker::mobile();
            $cont->ExpertName = Faker::firstName();
            $cont->ExpertFamily = Faker::lastName();
            $cont->ExpertPhone = 02535214125;
            $cont->ExpertMobile = Faker::mobile();
            $cont->address = Faker::address();
            $cont->phone = 02535214125;
            $cont->description = Faker::paragraph();
            $cont->OrgCode = 5001;
            $cont->save();

            $user = new User();
            $user->id = '7000'+$i;
            $user->name = $ContName;
            $user->username = '7000'+$i;
            $user->password = bcrypt(12345678);
            $user->type = 7;
            $user->subject = 'پیمانکار';
            $user->active = 1;
            $user->NTCP = 1;
            $user->created_at = now();
            $user->save();
        }
        for ($i = 5; $i < 10; $i++) {
            $ContName=Faker::word();
            $cont = new Contractor();
            $cont->ContCode = '7000'+$i;
            $cont->ContName = $ContName;
            $cont->ManagerName = Faker::firstName();
            $cont->ManagerFamily = Faker::lastName();
            $cont->ManagerPhone = 025165423142;
            $cont->ManagerMobile = Faker::mobile();
            $cont->ExpertName = Faker::firstName();
            $cont->ExpertFamily = Faker::lastName();
            $cont->ExpertPhone = 02535214125;
            $cont->ExpertMobile = Faker::mobile();
            $cont->address = Faker::address();
            $cont->phone = 02535214125;
            $cont->description = Faker::paragraph();
            $cont->OrgCode = 5002;
            $cont->save();

            $user = new User();
            $user->id = '7000'+$i;
            $user->name = $ContName;
            $user->username = '7000'+$i;
            $user->password = bcrypt(12345678);
            $user->type = 7;
            $user->subject = 'پیمانکار';
            $user->active = 1;
            $user->NTCP = 1;
            $user->created_at = now();
            $user->save();
        }
        for ($i = 11; $i < 15; $i++) {
            $ContName=Faker::word();
            $cont = new Contractor();
            $cont->ContCode = '7000'+$i;
            $cont->ContName = $ContName;
            $cont->ManagerName = Faker::firstName();
            $cont->ManagerFamily = Faker::lastName();
            $cont->ManagerPhone = 025165423142;
            $cont->ManagerMobile = Faker::mobile();
            $cont->ExpertName = Faker::firstName();
            $cont->ExpertFamily = Faker::lastName();
            $cont->ExpertPhone = 02535214125;
            $cont->ExpertMobile = Faker::mobile();
            $cont->address = Faker::address();
            $cont->phone = 02535214125;
            $cont->description = Faker::paragraph();
            $cont->OrgCode = 5003;
            $cont->save();

            $user = new User();
            $user->id = '7000'+$i;
            $user->name = $ContName;
            $user->username = '7000'+$i;
            $user->password = bcrypt(12345678);
            $user->type = 7;
            $user->subject = 'پیمانکار';
            $user->active = 1;
            $user->NTCP = 1;
            $user->created_at = now();
            $user->save();
        }
    }
}
