<?php

namespace Omnipay\Montonio\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Get access key.
     *
     * @return string access key
     */
    public function getAccessKey()
    {
        return $this->getParameter('accessKey');
    }

    /**
     * Set access key.
     *
     * @param string $value access key
     *
     * @return $this
     */
    public function setAccessKey($value)
    {
        return $this->setParameter('accessKey', $value);
    }

    /**
     * Get secret key.
     *
     * @return string secret key
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * Set secret key.
     *
     * @param string $value secret key
     *
     * @return $this
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    /**
     * Get payment method.
     *
     * @return string payment method
     */
    public function getPaymentMethod()
    {
        return $this->getParameter('paymentMethod');
    }

    /**
     * Set payment method.
     *
     * @param string $value payment method
     *
     * @return $this
     */
    public function setPaymentMethod($value)
    {
        return $this->setParameter('paymentMethod', $value);
    }

    /**
     * Get preferred country.
     *
     * @return string preferred country
     */
    public function getPreferredCountry()
    {
        return $this->getParameter('preferredCountry');
    }

    /**
     * Set preferred country.
     *
     * @param string $value preferred country
     *
     * @return $this
     */
    public function setPreferredCountry($value)
    {
        return $this->setParameter('preferredCountry', $value);
    }

    /**
     * Get preferred provider.
     *
     * @return string preferred provider
     */
    public function getPreferredProvider()
    {
        return $this->getParameter('preferredProvider');
    }

    /**
     * Set preferred provider.
     *
     * @param string $value preferred provider
     *
     * @return $this
     */
    public function setPreferredProvider($value)
    {
        return $this->setParameter('preferredProvider', $value);
    }

    /**
     * Get locale.
     *
     * @return string locale
     */
    public function getLocale()
    {
        return $this->getParameter('locale');
    }

    /**
     * Set locale.
     *
     * @param string $value locale
     *
     * @return $this
     */
    public function setLocale($value)
    {
        return $this->setParameter('locale', $value);
    }

    /**
     * Get language, if not set fallback to locale.
     *
     * @return string language
     */
    public function getLanguage()
    {
        $language = $this->getParameter('language');

        if (empty($language)) {
            $locale = $this->getLocale();

            if (empty($locale)) {
                return "";
            }

            // convert to IETF locale tag if other style is provided and then get first part, primary language
            $language = strtok(str_replace('_', '-', $locale), '-');
        }

        return strtoupper($language);
    }

    /**
     * Set language.
     *
     * @param string $value language
     *
     * @return $this
     */
    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    /**
     * Get period.
     *
     * @return int period
     */
    public function getPeriod()
    {
        return $this->getParameter('period') ?? 0;
    }

    /**
     * Set period.
     *
     * @param int $value period
     *
     * @return $this
     */
    public function setPeriod($value)
    {
        return $this->setParameter('period', $value);
    }
}
