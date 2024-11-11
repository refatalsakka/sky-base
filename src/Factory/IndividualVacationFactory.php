<?php

namespace App\Factory;

use App\Entity\IndividualVacation;
use App\Repository\IndividualRepository;
use App\Factory\Traits\RandomEntityTrait;
use App\Repository\IndividualLeaveReasonRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<IndividualVacation>
 */
final class IndividualVacationFactory extends PersistentProxyObjectFactory
{
    use RandomEntityTrait;

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(
        private IndividualRepository $individualRepository,
        private IndividualLeaveReasonRepository $individualLeaveReasonRepository,
    ) {
    }

    public static function class(): string
    {
        return IndividualVacation::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'endDate' => self::faker()->dateTime(),
            'individual' => $this->getRandomEntity($this->individualRepository),
            'reason' => $this->getRandomEntity($this->individualLeaveReasonRepository),
            'startDate' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(IndividualVacation $individualVacation): void {})
        ;
    }
}
