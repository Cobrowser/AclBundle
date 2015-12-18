<?php

/*
 * This file is part of the ProjectA AclBundle.
 *
 * (c) Daniel Tschinder
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ProjectA\Bundle\AclBundle\Security\Acl\Manager\AceManager;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Model\AclInterface;
use Symfony\Component\Security\Acl\Model\MutableAclInterface;
use Symfony\Component\Security\Acl\Model\SecurityIdentityInterface;

/**
 * @author Daniel Tschinder <daniel@tschinder.de>
 */
class ClassAceManager extends AbstractAceManager
{
    /**
     * {@inheritdoc}
     */
    protected function getAces(AclInterface $acl, $field = null)
    {
        return $field ? $acl->getClassFieldAces($field) : $acl->getClassAces();
    }

    /**
     * {@inheritdoc}
     */
    protected function insertAce(
        MutableAclInterface $acl,
        SecurityIdentityInterface $sid,
        $mask,
        $field = null,
        $index = 0,
        $granting = true,
        $strategy = null
    ) {
        if ($field) {
            $acl->insertClassFieldAce($field, $sid, $mask, $index, $granting, $strategy ?: $this->defaultStrategy);
        } else {
            $acl->insertClassAce($sid, $mask, $index, $granting, $strategy ?: $this->defaultStrategy);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function updateAce(MutableAclInterface $acl, $index, $mask, $field = null, $strategy = null)
    {
        if ($field) {
            $acl->updateClassFieldAce($index, $field, $mask, $strategy);
        } else {
            $acl->updateClassAce($index, $mask, $strategy);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function deleteAce(MutableAclInterface $acl, $index, $field = null)
    {
        if ($field) {
            $acl->deleteClassFieldAce($index, $field);
        } else {
            $acl->deleteClassAce($index);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function validateObject($object)
    {
        if (!is_string($object) && !$object instanceof ObjectIdentity && !is_object($object)) {
            throw new \InvalidArgumentException(
                'Object needs to be spcified as string, \Symfony\Component\Security\Acl\Domain\ObjectIdentity or domain object'
            );
        }
    }
}
