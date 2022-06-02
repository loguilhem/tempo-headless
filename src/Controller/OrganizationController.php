<?php

namespace App\Controller;

use App\Entity\Organization;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/api/organization", name="api_organization")
 */
class OrganizationController extends AbstractFOSRestController
{

    /**
     * em
     *
     * @var Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Rest\Post(
     *     path = "/",
     *     name = "_create",
     * )
     * @Rest\View(StatusCode = 201 )
     * @ParamConverter("organization", converter="fos_rest.request_body")
     */
    public function create(Organization $organization): Organization
    {
        $this->em->persist($organization);
        $this->em->flush();

        return $organization;
    }

    /**
     * @Rest\Get(
     *     path = "/{id}",
     *     name = "_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function show(Organization $organization): Organization
    {
        return $organization;
    }

    /**
     * @Rest\Put(
     *     path = "/{id}",
     *     name = "_update",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function update(Request $request, Organization $organization): Organization
    {
        $data = json_decode($request->getContent(), null);

        if (NULL !== $data) {
            $organization->setName($data->name);

            $this->em->persist($organization);
            $this->em->flush();
        }

        return $organization;
    }

    /**
     * @Rest\Delete(
     *     path = "/{id}",
     *     name = "_delete",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete(Organization $organization): Organization
    {

        $this->em->remove($organization);
        $this->em->flush();

        return $organization;
    }
}
