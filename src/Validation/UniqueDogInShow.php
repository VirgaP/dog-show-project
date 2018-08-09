<?php
/**
 * Created by PhpStorm.
 * User: ca_php_2s11
 * Date: 2018-06-26
 * Time: 10:04
 */

namespace App\Validation;


use App\Entity\Dog;
use App\Entity\Show;
use App\Repository\ShowRepository;
use PhpParser\Node\Expr\Instanceof_;
use Symfony\Component\Validator\Constraint;

/** @Annotation */
class UniqueDogInShow extends Constraint
{
    public $message = 'Dog "%dog%" is already registered to this show.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }

}