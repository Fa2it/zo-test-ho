<?php
/**
 * Created by PhpStorm.
 * User: Mary
 * Date: 08.05.2019
 * Time: 11:56
 */

namespace App\Helper\search;


use App\Entity\Ride;

class RideView
{

    public function getAnchor( Ride $ride ){
        $r = '';

        if( $ride ){
            $r .= '<a href="/my/search/'.$ride->getId().'/details" class="alert alert-dark btn btn-block font-weight-bold text-primary" role="alert">';
                $r .= '<div class="ride_details clearfix">';
                    $r .= '<div><i class="fas fa-running"></i> X  '.$ride->getPassengers().' </div>';
                    $r .= '<div class="row mx-auto">';
                        $r .= '<div class="col p-0">';
                            $r .= '<div style="border-right: 2px solid #c6c8ca; padding-right: 4px">';
                                        $r .= '<div class="w-100 text-right"> '.$ride->getPickUpTime()->format('H:i').'</div>';
                                $r .= '<div class="w-100 text-right"> '.$ride->getPickUp().' </div>';
                             $r .= '</div>';

                        $r .= '</div>';
                        $r .= '<div class="col p-0">';
                            $r .= '<div class="w-100 h-100">';
                                $r .= '<div class="mt-3 clearfix">';
                                    $r .= '<div class="float-left" style="width:11%"><i class="far fa-circle"></i></div>';
                                        $r .= '<div class="float-left" style="margin-top: -4px; width:78%"><hr /></div>';
                                        $r .= '<div class="float-left" style="width:11%"><i class="fas fa-arrow-alt-circle-right"></i></div>';
                                    $r .= '</div>';

                                $r .= '</div>';
                            $r .= '</div>';
                            $r .= '<div class="col p-0">';
                                $r .= '<div style="border-left: 2px solid #c6c8ca; padding-left: 4px">';
                                    $r .= '<div class="w-100 text-left"> '.$ride->getDropOffTime()->format('H:i').'</div>';
                                    $r .= '<div class="w-100 text-left"> '.$ride->getDropOff().' </div>';
                                $r .= '</div>';
                            $r .= '</div>';
                        $r .= '</div>';
                $r .= '</div>';
                $r .= '<hr>';
            $r .= '<div class="user_details clearfix">';
            $r .= '<div class="float-left mt-2">';
                    $r .= '<span> '.$ride->getPrice().'  €</span>';
                     $r .= '</div>';
                    $r .= ' <div class="float-right">';
                    $r .= '<div class="clearfix">';
                        $r .= '<div class="align-middle mr-3 float-left mt-2"> '.$ride->getUser()->getFirstName().' </div>';

                             if( $ride->getUser()->getPhoto()){
                                 $r .= '<img src="/media/images/'.$ride->getUser()->getPhoto().'" width="50" height="50" ';
                                 $r .= '     class="rounded-circle float-right" alt="person name  '.$ride->getUser()->getFirstName().' ">';
                             } else {
                                 $r .= ' <img src="/media/images/50.png" width="50" height="50"';
                                 $r .= ' class="rounded-circle float-right" alt="person name  '.$ride->getUser()->getFirstName().' ">';
                             }


                        $r .= ' </div>';
                    $r .= '</div>';
                $r .= '</div>';

            $r .= '</a>';
        }

        return $r;
    }

    public function  renderAnchor(Ride $ride){
            $r ='<a href="/my/search/'.$ride->getId().'/details" class="alert alert-dark btn btn-block font-weight-bold text-primary" role="alert">';
                    $r .='<hr class="mt-1 mb-1" style="border-width: 4px">';
                    $r .='<div class="user_details clearfix">';
                            $r .='<div class="float-left mt-2">';
                               $r .='<span> '.$ride->getPrice().' €</span>';
                            $r .='</div>';
                            $r .='<div class="float-right">';
                                $r .='<div class="clearfix">';
                                    $r .='<div class="align-middle mr-3 float-left mt-2"> '.$ride->getUser()->getFirstName().'</div>';

                                        if( $ride->getUser()->getPhoto()){
                                            $r .= '<img src="/media/images/'.$ride->getUser()->getPhoto().'" width="50" height="50" ';
                                            $r .= '     class="rounded-circle float-right" alt="person name  '.$ride->getUser()->getFirstName().' ">';
                                        } else {
                                            $r .= ' <img src="/media/images/50.png" width="50" height="50"';
                                            $r .= ' class="rounded-circle float-right" alt="person name  '.$ride->getUser()->getFirstName().' ">';
                                        }
                                $r .='</div>';
                            $r .='</div>';
                    $r .='</div>';
                    $r .='<div class="ride_details clearfix mt-n4">';
                            $r .='<div><i class="fas fa-running"></i> X '.$ride->getPassengers().'</div>';
                            $r .='<div class="clearfix">';
                                     $r .='<div class="float-left w-25">';
                                             $r .='<div style="border-right: 2px solid #c6c8ca;">';
                                                     $r .='<div class="text-right mr-1">'.$ride->getPickUpTime()->format('H:i').'</div>';
                                                     $r .='<div class="text-right mr-1">'.$ride->getPickUp().'</div>';
                                             $r .='</div>';
                                     $r .='</div>';
                                     $r .='<div class="float-left w-50">';
                                             $r .='<div class="">';
                                                     $r .='<div class="mt-3 clearfix">';
                                                             $r .='<div class="float-left" style="width:11%"><i class="far fa-circle"></i></div>';
                                                             $r .='<div class="float-left" style="margin-top: -4px; width:78%"><hr /></div>';
                                                             $r .='<div class="float-left" style="width:11%"><i class="fas fa-arrow-alt-circle-right"></i></div>';
                                                     $r .='</div>';
                                             $r .='</div>';
                                     $r .='</div>';
                                     $r .='<div class="float-left w-25">';
                                             $r .='<div style="border-left: 2px solid #c6c8ca;">';
                                                     $r .='<div class="text-left ml-1">'.$ride->getDropOffTime()->format('H:i').'</div>';
                                                     $r .='<div class="text-left ml-1">'.$ride->getDropOff().'</div>';
                                             $r .='</div>';
                                     $r .='</div>';
                            $r .='</div>';
                    $r .='</div>';
        $r .='</a>';

        return $r;
    }






}