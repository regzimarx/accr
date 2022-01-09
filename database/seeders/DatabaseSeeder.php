<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $designations = [
            "dc" => "Disciplinary Cases",
            "purp" => "Purposes and Objectives",
            "facu" => "Faculty",
            "inst" => "Instruction",
            "lib" => "Library",
            "lab" => "Laboratories",
            "ppf" => "Physical Plant and Facilities",
            "sps" => "Student Personnel Services",
            "socd" => "Social Orientation and Community Dev",
            "oa" => "Organization and Administration",
        ];

        extract($designations);

        foreach ($designations as $key => $designation) {
            \App\Models\Designation::create([
                "code" => $key,
                "designation_title" => $designation,
            ]);
        }

        $departments = [
            "sys_admin" => "System Administration",
            "cas" => "College of Arts and Sciences",
            "ccis" => "College of Computer and Information Sciences",
            "cba" => "College of Business and Accountancy",
            "csw" => "College of Social Work",
            "cmas" => "College of Midwifery and Allied Sciences",
            "cecd" => "College of Extension and Community Development",
            "cte" => "College of Teacher Education",
            "ca" => "College of Agriculture",
            "ct" => "College of Theology",
            "sao" => "Students Affairs Office",
            "alum" => "Alumni",
            "ext" => "Extensions",
            "res" => "Research",
            "scho" => "Scholarship",
            "hrdo" => "Human Resources Development Office",
            "lib" => "Library",
            "accr" => "Accreditor",
            "pres" => "President's Office",
            "paascu" =>
                "Philippine Accrediting Association of Schools, Colleges and Universities",
        ];

        extract($departments);

        foreach ($departments as $key => $department) {
            \App\Models\Department::create([
                "dept_code" => $key,
                "dept_name" => $department,
            ]);
        }

        $roles = [
            "admin" => "Administrator",
            "dean" => "Dean",
            "hrdo" => "Human Resources Development Officer",
            "coll_co" => "College Coordinator",
            "accr_co" => "Accreditation Coordinator",
            "scho_co" => "Scholarship Coordinator",
            "libr" => "Librarian",
            "unit_head" => "Unit Head",
            "board" => "Board of Trustees",
            "accr" => "Accreditor",
            "coll_pres" => "College President",
            "paascu" => "PAASCU Coordinator",
        ];

        extract($roles);

        foreach ($roles as $key => $role) {
            \App\Models\Role::create([
                "code" => $key,
                "role_title" => $role,
            ]);
        }

        // Add superadmin

        DB::table("users")->insert([
            "name" => "System Superadmin",
            "dept_id" => 1,
            "role_id" => 1,
            "email" => "sysadmin@gmail.com",
            "password" => Hash::make("sysadmin12345"),
        ]);
    }
}
