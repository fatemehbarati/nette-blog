<?php

namespace App\Presenters;

use App\Model\ArticleManager;
use Nette;


class HomepagePresenter extends Nette\Application\UI\Presenter
{
    /** @var  ArticleManager */
    private $articleManager;

    public function __construct(ArticleManager $articleManager)
    {
        parent::startup();
        $this->articleManager = $articleManager;
    }

    public function renderDefault(){

//        if (!$this->getUser()->isAllowed('article')){
//            throw new Nette\Application\ForbiddenRequestException('You do not have permission to this page.');
//        }
        $this->template->posts = $this->articleManager->getPublicArticles()->limit(5);
    }
}
