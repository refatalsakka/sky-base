<?php

namespace App\Factory;

use App\Entity\IndividualTemporaryGuest;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<IndividualTemporaryGuest>
 */
final class IndividualTemporaryGuestFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return IndividualTemporaryGuest::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'arrivalDate' => $arrivalDate = self::faker()->dateTime(),
            'departureDate' => self::faker()->randomElement([self::faker()->dateTimeBetween($arrivalDate, '+1 year'), null]),
            'originUnit' => self::faker()->randomElement([
                'الوحدة الخاصة', 
                'الكتيبة الأولى', 
                'الفيلق الثالث', 
                'فريق الإنقاذ', 
                'اللواء المدرع', 
                'الوحدة الجوية', 
                'فريق الدفاع الجوي', 
                'القوات البحرية', 
                'الكتيبة الهندسية',
                'فريق المظلات'
            ]),
            'notice' => self::faker()->randomElement([
                'الجندي قد تم إرساله من الوحدة لتلقي تدريب إضافي.',
                'الضابط جاء من الكتيبة بعد انتهاء مهمته الميدانية.',
                'الجندي من الوحدة الخاصة وتم نقله مؤقتًا.',
                'الجندي يخضع لفترة إعادة تأهيل في هذه الوحدة.',
                'الجندي تم نقله من الكتيبة الأولى لإكمال مهمة خاصة.',
                'الضابط من اللواء المدرع وتم توجيهه للمشاركة في تدريبات القيادة.',
                null
            ]),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(IndividualTemporaryGuest $individualTemporaryGuest): void {})
        ;
    }
}
