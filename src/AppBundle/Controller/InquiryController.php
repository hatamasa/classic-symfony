<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Inquiry;
use AppBundle\Entity\Mail;

/**
 * @Route("/inquiry")
 */
class InquiryController extends Controller
{

	/**
	 * @Route("/")
	 * @Method("get")
	 */
	public function indexAction()
	{
		return $this->render('Inquiry/index.html.twig',
				['form' => $this->createInquiryForm()->createView()]);
	}

	/**
	 * @Route("/")
	 * @Method("post")
	 */
	public function indexPostAction(Request $request)
	{
		// リクエストを取得
		$form = $this->createInquiryForm();
		$form->handleRequest($request);

		if($form->isValid()){
			$inquiry = $form->getData();

			// データベース登録処理
			$em = $this->getDoctrine()->getManager();
			$em->persist($inquiry);
			$em->flush();

			// メール送信処理
			$message = \Swift_Message::newInstance()
			->setSubject('Webサイトからのお知らせ')
			->setFrom('webmaster@example.com')
			->setTo('admin@example.com')
			->setBody(
					$this->renderView(
							'mail/Inquiry.txt.twig',
							['data' => $inquiry]
							)
					);

			// Gmailが送れないためテーブルに保存する
// 			$this->get('mailer')->send($message);
			$mail = new Mail();
			$mail->setMail($message);
			$em->persist($mail);
			$em->flush();

			return $this->redirect(
					$this->generateUrl('app_inquiry_complete'));
		}

		return $this->render('Inquiry/index.html.twig',
				['form' => $form->createView()]
		);
	}

	/**
	 * @Route("/complete")
	 */
	public function completeAction()
	{
		return  $this->render('Inquiry/complete.html.twig');
	}

	private function createInquiryForm()
	{
		return $this->createFormBuilder(new Inquiry())
		->add('name', 'text')
		->add('email', 'text')
		->add('tel', 'text', [
				'required' => false,
		])
		->add('type', 'choice', [
				'choices' => [
						'公演について',
						'その他',
				],
				'expanded' => true,
		])
		->add('content', 'textarea')
		->add('submit', 'submit', [
				'label' => '送信',
		])
		->getForm();
	}
}
