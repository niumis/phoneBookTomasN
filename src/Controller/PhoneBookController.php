<?php

namespace App\Controller;

use App\Entity\PhoneBook;
use App\Entity\Shared;
use App\Form\PhoneBookType;
use App\Form\ShareType;
use App\Repository\PhoneBookRepository;
use App\Repository\SharedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PhoneBookController
 *
 * @package App\Controller
 */
class PhoneBookController extends AbstractController
{
    /**
     * @Route("/")
     *
     * @return RedirectResponse
     */
    public function indexNoLocale()
    {
        return $this->redirectToRoute('phone_book_index_all', ['_locale' => 'en']);
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/all", name="phone_book_index_all", methods={"GET"})
     *
     * @param PhoneBookRepository $phoneBookRepository
     *
     * @return Response
     */
    public function indexAll(PhoneBookRepository $phoneBookRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $userContacts = $phoneBookRepository->findAllByUserAndShared($this->getUser());

        return $this->render(
            'phone_book/index.html.twig',
            [
                'userContacts' => $userContacts,
            ]
        );
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/own", name="phone_book_index_own", methods={"GET"})
     *
     * @param PhoneBookRepository $phoneBookRepository
     *
     * @return Response
     */
    public function indexOwn(PhoneBookRepository $phoneBookRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $userContacts = $phoneBookRepository->findAllByUser($this->getUser());

        return $this->render(
            'phone_book/index.html.twig',
            [
                'userContacts' => $userContacts,
            ]
        );
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/shared-by-user", name="phone_book_index_shared_with_me",
     *     methods={"GET"})
     *
     * @param SharedRepository $sharedRepository
     *
     * @return Response
     */
    public function indexSharedWithMe(SharedRepository $sharedRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $userContacts = $sharedRepository->findAllByUserShared($this->getUser());

        return $this->render(
            'phone_book/index_shared_by_user.html.twig',
            [
                'userContacts' => $userContacts,
            ]
        );
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/shared-with-users", name="phone_book_index_shared_with_users",
     *     methods={"GET"})
     *
     * @param SharedRepository $sharedRepository
     *
     * @return Response
     */
    public function indexSharedWithUsers(SharedRepository $sharedRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $userContacts = $sharedRepository->findAllSharedWithUsers($this->getUser());

        return $this->render(
            'phone_book/index_shared_with_user.html.twig',
            [
                'userContacts' => $userContacts,
            ]
        );
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/new", name="phone_book_new", methods={"GET","POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $phoneBook = new PhoneBook();

        $form = $this->createForm(PhoneBookType::class, $phoneBook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $phoneBook->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($phoneBook);
            $entityManager->flush();

            return $this->redirectToRoute('phone_book_index_all');
        }

        return $this->render(
            'phone_book/new.html.twig',
            [
                'phone_book' => $phoneBook,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/{id}", name="phone_book_show",
     *     requirements={"id":"\d+"}, methods={"GET"})
     *
     * @param PhoneBook $phoneBook
     *
     * @return Response
     */
    public function show(PhoneBook $phoneBook): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render(
            'phone_book/show.html.twig',
            [
                'phone_book' => $phoneBook,
            ]
        );
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/{id}/edit", name="phone_book_edit",
     *     requirements={"id":"\d+"}, methods={"GET","POST"})
     *
     * @param Request   $request
     * @param PhoneBook $phoneBook
     *
     * @return Response
     */
    public function edit(Request $request, PhoneBook $phoneBook): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(PhoneBookType::class, $phoneBook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('phone_book_index_all');
        }

        return $this->render(
            'phone_book/edit.html.twig',
            [
                'phone_book' => $phoneBook,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/{id}/share", name="phone_book_share",
     *     requirements={"id":"\d+"}, methods={"GET","POST"})
     *
     * @param Request   $request
     * @param PhoneBook $phoneBook
     *
     * @return Response
     */
    public function share(Request $request, PhoneBook $phoneBook): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $shared = new Shared();

        $form = $this->createForm(ShareType::class, $shared);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shared->setPhoneBook($phoneBook);
            $shared->setSharedByUser($this->getUser());
            $this->getDoctrine()->getManager()->persist($shared);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('phone_book_index_all');
        }

        return $this->render(
            'phone_book/share.html.twig',
            [
                'phone_book' => $phoneBook,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/{id}/unshare", name="phone_book_unshare",
     *     requirements={"id":"\d+"}, methods={"GET","POST"})
     *
     * @param Shared $shared
     *
     * @return Response
     */
    public function unshare(Shared $shared): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($shared);
        $entityManager->flush();

        return $this->redirectToRoute('phone_book_index_shared_with_users');
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/{id}", name="phone_book_delete",
     *     requirements={"id":"\d+"}, methods={"DELETE"})
     *
     * @param Request   $request
     * @param PhoneBook $phoneBook
     *
     * @return Response
     */
    public function delete(Request $request, PhoneBook $phoneBook): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isCsrfTokenValid('delete'.$phoneBook->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($phoneBook);
            $entityManager->flush();
        }

        return $this->redirectToRoute('phone_book_index_all');
    }
}
