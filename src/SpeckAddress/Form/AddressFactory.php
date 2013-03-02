<?php

namespace SpeckAddress\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AddressFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sl)
    {
        $form = $this->getForm();
        return $this->configure($form, $sl);
    }

    public function getForm()
    {
        return new Address;
    }

    public function configure(Address $form, ServiceLocatorInterface $sl)
    {
        $options = $sl->get('SpeckAddress\Options\ModuleOptions');

        $data = array(
            'weights'   => $options->getWeightedCountryCodes(),
            'spelling'  => $options->getAlternateSpellings(),
            'countries' => $sl->get('SpeckAddress\Service\Address')->getCountryList(),
        );

        $countryOptions = $this->getCountryOptions($data, $sl);
        $country = $form->get('country');
        $country->setAttribute('options', $countryOptions)
            ->setEmptyOption('--' . $country->getLabel() . '--');

        return $form;
    }

    public function getCountryOptions($data, $sl)
    {
        extract($data);

        $countryOptions[""] = "";
        foreach ($countries as $c) {
            $countryOptions[] = array(
                'label' => utf8_encode($c['country']),
                'value' => $c['country_code'],
                'weight' => isset($weights[$c['country_code']]) ? $weights[$c['country_code']] : 1,
                'alt-spelling' => isset($spelling[$c['country_code']]) ? $spelling[$c['country_code']] : '',
            );
        }

        return $countryOptions;
    }
}
