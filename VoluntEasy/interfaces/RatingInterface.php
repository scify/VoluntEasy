<?php

namespace Interfaces;

/**
 * Interface RatingInterface
 */
interface RatingInterface
{
    public function hasCustomRatings();

    public function rateVolunteers($token);
}
