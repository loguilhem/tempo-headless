<?php

namespace App\Controller;

use App\Entity\Organization;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class OrganizationController extends AbstractFOSRestController
{
    /**
     * @Rest\Post(
     *     path = "/organization",
     *     name = "organization_create",
     * )
     * @Rest\View(StatusCode = 201 )
     * @ParamConverter("organization", converter="fos_rest.request_body")
     */
    public function createOrganization(Organization $organization)
    {
        $em = $this->getDoctrine()->getManager();

        $em->persist($organization);
        $em->flush();
    }

    /**
     * @Rest\Get(
     *     path = "/organization/{id}",
     *     name = "organization_read",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function readOrganization(Organization $organization): Organization
    {
        return $organization;
    }

    /**
     * @Rest\Put(
     *     path = "/organization/{id}",
     *     name = "organization_update",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function updateOrganization(Request $request, Organization $organization): Organization
    {
        $data = json_decode($request->getContent(),null);

        if (NULL !== $data) {
            $em = $this->getDoctrine()->getManager();
            
            $organization->setName($data->name);

            $em->persist($organization);
            $em->flush();
        }
        
        return $organization;
    }

    /**
     * @Rest\Delete(
     *     path = "/organization/{id}",
     *     name = "organization_delete",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function deleteOrganization(Organization $organization): Organization
    {
        $em = $this->getDoctrine()->getManager();
        
        $em->remove($organization);
        $em->flush();
        
        return $organization;
    }
}
