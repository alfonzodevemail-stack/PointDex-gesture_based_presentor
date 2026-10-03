<?php

namespace Database\Factories;

use App\Models\Presentation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Presentation>
 */
class PresentationFactory extends Factory
{
    protected $model = Presentation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sampleTitles = [
            'Event-Driven Architecture (EDA) & Reactive Systems',
            'PointDex: Real-Time Optical Presentation Control',
            'Computer Vision with MediaPipe Hands & WebAssembly',
            'ISO/IEC 25010 Quality Model Usability Benchmarking',
            'UN SDG 9 & 12: Sustainable Digital Presentation Tech',
            'Zero-Latency Client-Side Input Pipelines',
            'Edge Computing & Browser Machine Learning Inference',
            'Non-Blocking Event Loops in Modern Web Standards',
            'Agile Scrum Development Lifecycle for CV Applications',
            'Mitigating Asynchronous Race Conditions in DOM Dispatch',
            'Next-Gen Human-Computer Interaction (HCI) Interfaces',
            'Telemetry Logger & System Latency Profiling'
        ];

        return [
            'user_id' => User::factory(),
            'title' => fake()->randomElement($sampleTitles) . ' (' . fake()->city() . ' Keynote)',
            'description' => fake()->paragraph(2),
            'slide_count' => fake()->numberBetween(8, 45),
            'sensitivity' => fake()->randomElement(['Low', 'Medium', 'High']),
            'cooldown_ms' => fake()->randomElement([500, 600, 800, 1000, 1500]),
            'status' => fake()->randomElement(['Ready', 'Draft', 'Archived']),
        ];
    }
}