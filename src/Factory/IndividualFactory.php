<?php

namespace App\Factory;

use App\Entity\Individual;
use App\Entity\MilitaryRank;
use App\Repository\UnitRepository;
use App\Repository\ReligionRepository;
use App\Repository\BloodTypeRepository;
use App\Factory\Traits\RandomEntityTrait;
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
    use RandomEntityTrait;

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
        $MilitaryRankEntity = $this->getRandomEntity($this->militaryRankRepository);

        return [
            'address' => self::faker()->address(),
            'birthdate' => self::faker()->dateTimeBetween('-60 years', '-18 years'),
            'bloodType' => $this->getRandomEntity($this->bloodTypeRepository),
            'detentionTimes' => self::faker()->numberBetween(0, 5),
            'educationLevel' => $this->getRandomEntity($this->educationLevelRepository),
            'fatherAlive' => self::faker()->boolean(),
            'image' => self::faker()->imageUrl(640, 480, 'people'),
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
            'religion' => $this->getRandomEntity($this->religionRepository),
            'socialStatus' => $this->getRandomEntity($this->socialStatusRepository),
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
            'status' => $this->getRandomEntity($this->individualStatusRepository),
            'task' => $this->getRandomEntity($this->individualTaskRepository),
            'unit' => $this->getRandomEntity($this->unitRepository),
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
