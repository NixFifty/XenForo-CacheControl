<?php

class NixFifty_CacheControl_XenForo_ControllerPublic_Attachment extends XFCP_NixFifty_CacheControl_XenForo_ControllerPublic_Attachment
{
    public function actionIndex()
    {
        $response = parent::actionIndex();

        if ($response instanceof XenForo_ControllerResponse_View AND isset($response->params['attachment']))
        {
            if ($response->params['attachment']['content_type'] == 'post')
            {
                /** @var XenForo_Model_Attachment $attachmentModel */
            $attachmentModel = $this->getModelFromCache('XenForo_Model_Attachment');

            $response->params['attachment']['is_public'] = $attachmentModel->isPublicAttachment($response->params['attachment']);
            }
        }

        return $response;
    }
}