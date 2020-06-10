<?php


namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Eleve;
use App\Entity\Note;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class NoteTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testGetNotesCollection(): void
    {
        $response = static::createClient()->request("GET",'http://ubitrans-exo.loc/api/notes');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceCollectionJsonSchema(Note::class);
    }

    public function testAjoutNote(): void
    {
        $response = static::createClient()->request("POST", 'http://ubitrans-exo.loc/api/notes', ['json' => [
            "note" => 18,
            "matiere" => 'SVT',
            "eleve" => $this->findIriBy(Eleve::class, ['nom' => 'Ullrich'])
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertRegExp('~^/api/notes/\d+$~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(Note::class);
    }

    public function testAjoutNoteParIdEleve(): void
    {
        $id = 176;
        $response = static::createClient()->request("POST", 'http://ubitrans-exo.loc/api/note/eleve/'+$id, ['json' => [
            "note" => 18,
            "matiere" => 'SVT',
            "eleve" => $this->findIriBy(Eleve::class, ['id' => 176])
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertRegExp('~^/api/notes/\d+$~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(Note::class);
    }

    public function testAjoutNoteIncomplete(): void
    {
        $response = static::createClient()->request("POST", 'http://ubitrans-exo.loc/api/eleves', ['json' => [
            'note' => 15,
        ]]);

        $this->assertResponseStatusCodeSame(500);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

    }


    public function testNoteEdition(): void
    {
        $client = static::createClient();

        $iri = $this->findIriBy(Note::class, ['id' => '176']);
        $client->request('PUT', $iri, ['json' => [
            'note' => 8,
        ]]);
        $this->assertResponseIsSuccessful();

    }

    public function testDeleteNote(): void
    {
        $client = static::createClient();
        $iri = $this->findIriBy(Note::class, ['id' => '176']);
        $client->request('DELETE', $iri);
        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            static::$container->get('doctrine')->getRepository(Note::class)->findOneBy(['id' => '176'])
        );
    }

}
