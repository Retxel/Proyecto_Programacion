<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @mixin \Illuminate\Foundation\Testing\TestCase
 * @mixin \Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication
 * @mixin \Illuminate\Foundation\Testing\Concerns\MakesHttpRequests
 */
class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_pagina_de_perfil_se_muestra(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_la_informacion_del_perfil_se_puede_actualizar(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Usuario Prueba',
                'email' => 'prueba@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Usuario Prueba', $user->name);
        $this->assertSame('prueba@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_el_estado_de_verificacion_del_correo_no_cambia_cuando_el_correo_es_el_mismo(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Usuario Prueba',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_el_usuario_puede_eliminar_su_cuenta(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_se_debe_proporcionar_la_contrasena_correcta_para_eliminar_la_cuenta(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
