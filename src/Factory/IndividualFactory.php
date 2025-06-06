<?php

namespace App\Factory;

use App\Entity\Individual;
use App\Entity\MilitaryRank;
use App\Repository\UnitRepository;
use App\Repository\ReligionRepository;
use App\Repository\BloodTypeRepository;
use App\Factory\Util\ImageGeneratorTrait;
use App\Repository\MilitaryRankRepository;
use App\Repository\SocialStatusRepository;
use App\Repository\EducationLevelRepository;
use App\Repository\IndividualTaskRepository;
use App\Repository\IndividualStatusRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Individual>
 */
final class IndividualFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(
        private BloodTypeRepository $bloodTypeRepository,
        private EducationLevelRepository $educationLevelRepository,
        private MilitaryRankRepository $militaryRankRepository,
        private ReligionRepository $religionRepository,
        private SocialStatusRepository $socialStatusRepository,
        private IndividualStatusRepository $individualStatusRepository,
        private IndividualTaskRepository $individualTaskRepository,
        private UnitRepository $unitRepository,
    ) {
    }

    public static function class(): string
    {
        return Individual::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        /** @var MilitaryRank */
        $MilitaryRankEntity = MilitaryRankFactory::random();

        return [
            'address' => self::faker()->address(),
            'birthdate' => self::faker()->dateTimeBetween('-60 years', '-18 years'),
            'bloodType' => BloodTypeFactory::random(),
            'detentionTimes' => self::faker()->numberBetween(0, 5),
            'educationLevel' => EducationLevelFactory::random(),
            'fatherAlive' => self::faker()->boolean(),
            'image' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAC0AQMAAAAHA5RxAAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAcklEQVRYhWNgGAXkgw8JBdiEGWckGGAXZ8AUN5c+fLDhgYENurhlX1piQ4JBGrq4wRke8wcJBoexiBsC1f/HIX4Aw/weNpD5yRju4WE+2Pijwg7DHAyX4xcfBaNgFIyCUTAKRsEoGAWjYBSMglEwCugHAJo1GlHYL8FWAAAAAElFTkSuQmCC',
            'imprisonmentTimes' => self::faker()->numberBetween(0, 2),
            'joinDate' => self::faker()->dateTimeBetween('-40 years', 'now'),
            'militaryId' => self::faker()->regexify('MIL[0-9]{6}'),
            'militaryRank' => $MilitaryRankEntity,
            'militarySubRank' => self::faker()->randomElement(
                $MilitaryRankEntity->getSubRanks()
            ),
            'mobileNumber' => self::faker()->phoneNumber(),
            'motherAlive' => self::faker()->boolean(),
            'name' => self::faker()->firstName('male') . ' ' . self::faker()->lastName('male'),
            'nationalId' => self::faker()->regexify('ID[0-9]{7}'),
            'placeOfBirth' => self::faker()->city(),
            'profession' => self::faker()->randomElement([
                'مهندس', 
                'طبيب', 
                'ممرض', 
                'محاسب', 
                'معلم', 
                'مطور برمجيات', 
                'محامي', 
                'مدير مشروع', 
                'ميكانيكي', 
                'ضابط شرطة'
            ]),
            'registerDate' => self::faker()->dateTimeBetween('-30 years', 'now'),
            'releaseDate' => self::faker()->dateTimeBetween('now', '+2 years'),
            'religion' => ReligionFactory::random(),
            'socialStatus' => SocialStatusFactory::random(),
            'specialization' => self::faker()->randomElement([
                'المشاة', 
                'اللوجستيات', 
                'الاتصالات', 
                'الهندسة', 
                'الخدمات الطبية', 
                'المدفعية', 
                'الاستخبارات', 
                'الطيران', 
                'الوحدات المدرعة', 
                'سلاح الإشارة'
            ]),
            'status' => IndividualStatusFactory::random(),
            'task' => IndividualTaskFactory::random(),
            'unit' => UnitFactory::random(),
            'seniorityNumber' => self::faker()->regexify('[A-Z]{2}[0-9]{4}'),
            'college' => self::faker()->word(),
            'institute' => self::faker()->word(),
            'graduationDate' => self::faker()->dateTimeBetween('-30 years', '-1 year'),
            'serviceStartDate' => self::faker()->dateTimeBetween('-40 years', '-5 years'),
            'currentRankPromotionDate' => self::faker()->dateTimeBetween('-5 years', 'now'),
            'nextRankPromotionDate' => self::faker()->dateTimeBetween('now', '+5 years'),
            'weapon' => self::faker()->word(),
            'administration' => self::faker()->word(),
            'mainUnit' => self::faker()->word(),
            'attachment' => self::faker()->word(),
            'livingForce' => self::faker()->word(),
            'subUnit' => self::faker()->word(),
            'militaryQualification' => self::faker()->word(),
            'civilianQualification' => self::faker()->word(),
            'medicalLevel' => self::faker()->word(),
            'governorate' => self::faker()->city(),
            'securityStatus' => self::faker()->word(),
            'literacyStatus' => self::faker()->randomElement(['Literate', 'Illiterate']),
            'notes' => self::faker()->sentence(),
            'category' => self::faker()->word(),
            'wivesCount' => self::faker()->numberBetween(0, 3),
            'childrenCount' => self::faker()->numberBetween(0, 6),
            'weight' => self::faker()->randomFloat(2, 50, 100),
            'height' => self::faker()->randomFloat(2, 150, 200),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Individual $individual): void {})
        ;
    }
}
