<?php

namespace awssat\Visits\Traits;

trait Setters
{
    /**
     * Return fresh cache from database
     * @return $this
     */
    public function fresh()
    {
        $this->fresh = true;

        return $this;
    }

    /**
     * set x seconds for ip expiration
     *
     * @param $seconds
     * @return $this
     */
    public function seconds($seconds)
    {
        $this->ipSeconds = $seconds;

        return $this;
    }


    /**
     * @param $country
     * @return $this
     */
    public function country($country)
    {
        $this->country = $country;

        return $this;
    }


    /**
     * @param $referer
     * @return $this
     */
    public function referer($referer)
    {
        $this->referer = $referer;

        return $this;
    }


    /**
     * Change period
     *
     * @param $period
     * @return $this
     */
    public function period($period)
    {
        if (in_array($period, $this->periods)) {
            $this->keys->visits = $this->keys->period($period);
        }

        return $this;
    }
}
