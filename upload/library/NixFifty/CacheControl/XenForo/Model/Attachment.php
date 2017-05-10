<?php

class NixFifty_CacheControl_XenForo_Model_Attachment extends XFCP_NixFifty_CacheControl_XenForo_Model_Attachment
{
    public function isPublicAttachment(array $attachment)
    {
        /** @var XenForo_Model_User $userModel */
        $userModel = XenForo_Model::create('XenForo_Model_User');
        $guest = $userModel->getVisitingGuestUser();

        return $this->canViewAttachment($attachment, '', $guest);
    }
}