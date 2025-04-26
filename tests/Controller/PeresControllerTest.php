<?php

namespace App\Tests\Controller;

use App\Entity\Peres;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PeresControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $pereRepository;
    private string $path = '/peres/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->pereRepository = $this->manager->getRepository(Peres::class);

        foreach ($this->pereRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Pere index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'pere[fullname]' => 'Testing',
            'pere[email]' => 'Testing',
            'pere[adresse]' => 'Testing',
            'pere[createdAt]' => 'Testing',
            'pere[updatedAt]' => 'Testing',
            'pere[slug]' => 'Testing',
            'pere[nom]' => 'Testing',
            'pere[prenom]' => 'Testing',
            'pere[profession]' => 'Testing',
            'pere[nina]' => 'Testing',
            'pere[telephone1]' => 'Testing',
            'pere[telephone2]' => 'Testing',
            'pere[createdBy]' => 'Testing',
            'pere[updatedBy]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->pereRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Peres();
        $fixture->setFullname('My Title');
        $fixture->setEmail('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setSlug('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setProfession('My Title');
        $fixture->setNina('My Title');
        $fixture->setTelephone1('My Title');
        $fixture->setTelephone2('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setUpdatedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Pere');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Peres();
        $fixture->setFullname('Value');
        $fixture->setEmail('Value');
        $fixture->setAdresse('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setProfession('Value');
        $fixture->setNina('Value');
        $fixture->setTelephone1('Value');
        $fixture->setTelephone2('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'pere[fullname]' => 'Something New',
            'pere[email]' => 'Something New',
            'pere[adresse]' => 'Something New',
            'pere[createdAt]' => 'Something New',
            'pere[updatedAt]' => 'Something New',
            'pere[slug]' => 'Something New',
            'pere[nom]' => 'Something New',
            'pere[prenom]' => 'Something New',
            'pere[profession]' => 'Something New',
            'pere[nina]' => 'Something New',
            'pere[telephone1]' => 'Something New',
            'pere[telephone2]' => 'Something New',
            'pere[createdBy]' => 'Something New',
            'pere[updatedBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/peres/');

        $fixture = $this->pereRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getFullname());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getAdresse());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getProfession());
        self::assertSame('Something New', $fixture[0]->getNina());
        self::assertSame('Something New', $fixture[0]->getTelephone1());
        self::assertSame('Something New', $fixture[0]->getTelephone2());
        self::assertSame('Something New', $fixture[0]->getCreatedBy());
        self::assertSame('Something New', $fixture[0]->getUpdatedBy());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Peres();
        $fixture->setFullname('Value');
        $fixture->setEmail('Value');
        $fixture->setAdresse('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setProfession('Value');
        $fixture->setNina('Value');
        $fixture->setTelephone1('Value');
        $fixture->setTelephone2('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/peres/');
        self::assertSame(0, $this->pereRepository->count([]));
    }
}
