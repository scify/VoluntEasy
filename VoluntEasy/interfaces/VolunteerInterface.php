<?php

namespace Interfaces;

/**
 * Interface VolunteerInterface
 */
interface VolunteerInterface
{
    public function store();

    public function update($volunteer);

    public function apiStore();
}
