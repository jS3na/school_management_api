<?php

namespace Database\Seeders;

use App\Models\ClassM;
use App\Models\ClassStudents;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criando usuários manualmente
        $user1 = User::create([
            'name' => 'aluno1',
            'email' => 'aluno1@gmail.com',
            'password' => Hash::make('senha')
        ]);

        $user2 = User::create([
            'name' => 'aluno2',
            'email' => 'aluno2@gmail.com',
            'password' => Hash::make('senha')
        ]);

        $user3 = User::create([
            'name' => 'professor1',
            'email' => 'professor1@gmail.com',
            'password' => Hash::make('senha')
        ]);

        $class = ClassM::create([
            'name' => 'Classe Teste'
        ]);

        // Criando alunos sem factory
        $student1 = Student::create([
            'user_id' => $user1->id,
            'birth_date' => Carbon::parse('2005-06-15'),
            'address' => 'Rua Exemplo, 123',
            'phone' => '99999-9999',
            'guardian' => 'Responsável 1',
            'class_id' => $class->id
        ]);

        $student2 = Student::create([
            'user_id' => $user2->id,
            'birth_date' => Carbon::parse('2006-08-10'),
            'address' => 'Rua Exemplo, 456',
            'phone' => '88888-8888',
            'guardian' => 'Responsável 2',
            'class_id' => $class->id
        ]);

        // Criando professor sem factory
        $teacher = Teacher::create([
            'user_id' => $user3->id,
            'salary' => 100.00
        ]);

        echo "Seeder executado com sucesso!\n";
    }
}
