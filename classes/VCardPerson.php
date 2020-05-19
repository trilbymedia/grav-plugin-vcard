<?php
namespace Grav\Plugin\VCard;

use JeroenDesloovere\VCard\VCard;

class VCardPerson
{
    /** @var VCard */
    protected $vcard;

    /**
     * VCard constructor.
     * @param null $person
     */
    public function __construct($person)
    {
        $this->vcard = new VCard();

        if (is_array($person)) {
            $person = (object) $person;
        }
        $this->setPerson($person);

        return $this;
    }

    /**
     * @param $person
     * @return $this
     */
    public function setPerson($person): VCardPerson
    {
        if (isset($person->name)) {
            $this->vcard->addName($person->name);
        }

        if (isset($person->title)) {
            $this->vcard->addJobtitle($person->title);
        }

        if (isset($person->company))  {
            $this->vcard->addCompany($person->company);
        }

        if (isset($person->email)) {
            $this->vcard->addEmail($person->email);
        }

        if (isset($person->office_phone)) {
            $this->vcard->addPhoneNumber($person->office_phone, "Office Phone");
        }

        if (isset($person->mobile_phone)) {
            $this->vcard->addPhoneNumber($person->mobile_phone, "Mobile Phone");
        }

        if (isset($person->fax)) {
            $this->vcard->addPhoneNumber($person->fax, "Fax Number");
        }

        if (isset($person->address)) {
            $this->vcard->addAddress($person->address);
        }

        if (isset($person->website)) {
            $this->vcard->addURL($person->website);
        }

        if (isset($person->photo)) {
            $this->vcard->addPhoto($person->photo);
        }

        return $this;
    }

    public function generate()
    {
        echo $this->vcard->getOutput();
    }
}