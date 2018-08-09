<?php
/**
 * Created by PhpStorm.
 * User: ca_php_2s11
 * Date: 2018-06-26
 * Time: 14:05
 */

namespace App\Validation;


use App\Repository\ShowRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueDogInShowValidator extends ConstraintValidator
{
    private $repository;

    public function __construct(ShowRepository $repository)
    {
        $this->repository = $repository;
    }


    public function validate($value, Constraint $constraint)
    {
//        echo '<pre>';var_dump($value->getShow()->getId());

        $dogsRegistered = $this->repository
           ->findShowsByDog($value->getDog());


        if (in_array($value->getShow(),$dogsRegistered)) {

           $this->context->buildViolation($constraint->message)->addViolation();

        }

//        else if ($value->getDog() !=null) {
//            return $dogsRegistered;
//
//        }

    }
}

//$object = $this->context->getObject();
//
//// Create data
//if (null == $object->getId()) {
//    -- enter code for check validation
//}
//
//// Update data
//if ($object->getId() != null) {
//    -- check value (if same data just return;) --
//    -- if value has changed just enter code for check validation --
//}