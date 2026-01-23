<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(ProductSeeder::class);

        Form::factory()
            ->count(3)
            ->hasFields(2)
            ->create();

        // Create submissions for existing forms
        $forms = Form::with('fields')->get();
        foreach ($forms as $form) {
            for ($i = 0; $i < rand(5, 15); $i++) {
                $data = [];
                foreach ($form->fields as $field) {
                    if ($field->type === 'number') {
                        $data[$field->label] = fake()->numberBetween(1, 100);
                    } elseif ($field->type === 'email') {
                        $data[$field->label] = fake()->email();
                    } elseif ($field->type === 'date') {
                        $data[$field->label] = fake()->date();
                    } else {
                        $data[$field->label] = fake()->word();
                    }
                }
                \App\Models\Formsubmission::create([
                    'form_id' => $form->id,
                    'data' => json_encode($data),
                ]);
            }
        }
    }
}
