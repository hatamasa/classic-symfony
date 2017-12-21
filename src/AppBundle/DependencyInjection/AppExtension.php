<?php
namespace AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use AppBundle\Entity\MemberCollection;

class AppExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $config = $this->processConfiguration(new Configuration(), $configs);

        $this->buildMemberCollectionDefinition($container, $config['members']);

    }

    private function buildMemberCollectionDefinition(ContainerBuilder $container, $memberList)
    {
        $collectionDefinition = $container->register('app.member_collection', MemberCollection::class);

        foreach($memberList as $name => $memberInfo){
            $collectionDefinition->addMethodCall('addMember', [
                $name, $memberInfo['part'], $memberInfo['joinedDate']
            ]);
        }
    }

    public function getAlias()
    {
        return 'app';
    }

}
