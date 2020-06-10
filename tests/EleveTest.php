<?php


namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Eleve;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class EleveTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testGetEleveCollection(): void
    {
        $response = static::createClient()->request("GET",'http://ubitrans-exo.loc/api/eleves');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceCollectionJsonSchema(Eleve::class);
    }

    public function testAjoutEleve(): void
    {
        $response = static::createClient()->request("POST", 'http://ubitrans-exo.loc/api/eleves', ['json' => [
            'nom' => 'Atreides',
            'prenom' => 'Paul',
            'dateNaissance' => '1990-07-31T00:00:00+00:00'
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
      /*  $this->assertJsonContains([
            '@context' => '/api/contexts/Eleve',
            '@type' => 'Eleve',
            'nom' => 'Atreides',
            'prenom' => 'Paul',
            'dateNaissance' => '1990-07-31T00:00:00+00:00',
        ]); necessite phpunit 8 */
        $this->assertRegExp('~^/api/eleves/\d+$~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(Eleve::class);
    }

    public function testAjoutEleveIncomplet(): void
    {
        $response = static::createClient()->request("POST", 'http://ubitrans-exo.loc/api/eleves', ['json' => [
            'nom' => 'Harkonnen',
        ]]);
        $this->assertResponseStatusCodeSame(500);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

    }


    public function testEleveEdition(): void
    {
        $client = static::createClient();

        $iri = $this->findIriBy(Eleve::class, ['nom' => 'Ullrich']);
        var_dump($iri);
        $client->request('PUT', $iri, ['json' => [
            'prenom' => 'Leto',
        ]]);
        $this->assertResponseIsSuccessful();

    }

    public function testDeleteBook(): void
    {
        $client = static::createClient();
        $iri = $this->findIriBy(Eleve::class, ['nom' => 'Ullrich']);
        $client->request('DELETE', $iri);
        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            static::$container->get('doctrine')->getRepository(Eleve::class)->findOneBy(['nom' => 'Ullrich'])
        );
    }

}
