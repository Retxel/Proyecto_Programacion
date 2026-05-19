<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Un ejemplo de prueba funcional básica.
     */
    public function test_la_aplicacion_retorna_una_respuesta_exitosa(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }
}
