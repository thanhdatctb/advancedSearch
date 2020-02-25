<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class VisibilityEnum extends Enum
{
    const Store_pages = "storefront";
    const Checkout = "checkout";
    const Order_confirmation = "order_confirmation";
    const All_pages = "all_pages";
}
