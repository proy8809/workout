<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class TagFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $tags = [
            new Tag(title: "Announcement", canonical: "announcement"),
            new Tag(title: "Important", canonical: "important"),
            new Tag(title: "Spoiler", canonical: "spoiler"),
            new Tag(title: "NSFW", canonical: "nsfw"),
        ];

        foreach ($tags as $tag) {
            $manager->persist($tag);
        }

        $manager->flush();
    }

    /**
     * @return list<string>
     */
    public static function getGroups(): array
    {
        return ["bootstrap"];
    }
}