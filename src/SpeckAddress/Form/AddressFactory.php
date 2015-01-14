<?php

namespace SpeckAddress\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SpeckAddress\Form\AddressFormInterface;

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

    public function configure(AddressFormInterface $form, ServiceLocatorInterface $sl)
    {
        $options = $sl->get('SpeckAddress\Options\ModuleOptions');
        $service = $sl->get('SpeckAddress\Service\Address');

        $countryData = array(
            'weights'   => $options->getWeightedCountryCodes(),
            'spelling'  => $options->getAlternateSpellings(),
            'countries' => $service->getCountryList(),
        );
        $countryOptions = $this->getCountryOptions($countryData, $sl);
        $country = $form->get('country');
        $country->setAttribute('options', $countryOptions)
            ->setEmptyOption('--' . $country->getLabel() . '--');

        $provinceData = array(
            'weights'   => $options->getWeightedCountryCodes(),
            'provinces' => $service->getProvinceList(),
        );

        $provinceOptions = $this->getProvinceOptions($provinceData, $sl);
        $province = $form->get('province');
        $province->setAttribute('options', $provinceOptions)
            ->setEmptyOption('--' . $province->getLabel() . '--');

        return $form;
    }

    public function getProvinceOptions($data, $sl)
    {
        extract($data);

        $opts = array();
        foreach ($provinces as $p) {
            if (!isset($opts[$p['country_code']])) {
                $opts[$p['country_code']]= array(
                    'label' => $p['country_name'],
                    'options' => array(),
                );
            }
            $opts[$p['country_code']]['options'][$p['country_province_code']] = $p['province_name'];
        }

        return $this->resortProvinceOptionsByWeight($opts, $weights);
    }

    public function resortProvinceOptionsByWeight($options, array $weights = array())
    {
        if (count($weights) === 0) {
            return $options;
        }

        $return = array();

        foreach ($weights as $countryCode => $weight) {
            $return[] = $options[$countryCode];
            unset($options[$countryCode]);
        }

        foreach ($options as $opt) {
            $return[] = $opt;
        }

        return $return;
    }

    public function getCountryOptions($data, $sl)
    {
        extract($data);

        $countryOptions[""] = "";
        foreach ($countries as $c) {
            $countryOptions[] = array(
                'label' => $c['country'],
                'value' => $c['country_code'],
                'weight' => isset($weights[$c['country_code']]) ? $weights[$c['country_code']] : 1,
                'alt-spelling' => isset($spelling[$c['country_code']]) ? $spelling[$c['country_code']] : '',
            );
        }

        return $countryOptions;
    }
}
