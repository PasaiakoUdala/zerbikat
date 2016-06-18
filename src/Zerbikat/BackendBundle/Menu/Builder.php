<?php
// src/Zerbikat/BackendBundle/Menu/Builder.php
namespace Zerbikat\BackendBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
//        $menu = $factory->createItem('root');
//
//        $menu->addChild('Fitxa', array('route' => 'fitxa_index'),
//            array('class' => 'nav navbar-nav navbar-right')
//            );
//
//        $menu->addChild('Informations')->setAttribute('dropdown', true);
////
////        // access services from the container!
////        $em = $this->container->get('doctrine')->getManager();
////        // findMostRecent and Blog are just imaginary examples
////        $blog = $em->getRepository('AppBundle:Blog')->findMostRecent();
////
////        $menu->addChild('Latest Blog Post', array(
////            'route' => 'blog_show',
////            'routeParameters' => array('id' => $blog->getId())
////        ));
////
////        // create another menu item
//        $menu->addChild('About Me', array('route' => 'araudia_index'));
////        // you can also add sub level's to your menu's as follows
//        $menu['About Me']->addChild('Fitxa', array('route' => 'araudia_index'));
////
////        // ... add more children


        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');

        $menu->addChild('Fitxa', array('route' => 'fitxa_index'))
            ->setAttribute('icon', 'icon-list');

        $menu->addChild('Araudia', array('route' => 'araudia_index'))
            ->setAttribute('icon', 'icon-group');



        $menu->addChild('User', array('label' => 'Hi visitor'))
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'icon-user');
        $menu['User']->addChild('Edit profile', array('route' => 'dokumentazioa_index'))
            ->setAttribute('icon', 'icon-edit');


        return $menu;

















        return $menu;
    }
}