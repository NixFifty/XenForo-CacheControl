<?php

class NixFifty_CacheControl_XenForo_ViewPublic_Attachment_View extends XFCP_NixFifty_CacheControl_XenForo_ViewPublic_Attachment_View
{
    public function renderRaw()
    {
        // todo: currently overwriting the original class cause it breaks otherwise...

        $attachment = $this->_params['attachment'];

        if (!headers_sent() && function_exists('header_remove') && isset($attachment['is_public']))
        {
            header_remove('Expires');
            if ($attachment['is_public'])
            {
                $maxAge = XenForo_Application::getOptions()->get('nfCacheMaxAge');

                header("Cache-Control: max-age=$maxAge, public");
            }
            else
            {
                header('Cache-control: private');
            }
        }

        $extension = XenForo_Helper_File::getFileExtension($attachment['filename']);
        $imageTypes = array(
            'gif' => 'image/gif',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpe' => 'image/jpeg',
            'png' => 'image/png'
        );

        if (in_array($extension, array_keys($imageTypes)))
        {
            $this->_response->setHeader('Content-type', $imageTypes[$extension], true);
            $this->setDownloadFileName($attachment['filename'], true);
        }
        else
        {
            $this->_response->setHeader('Content-type', 'application/octet-stream', true);
            $this->setDownloadFileName($attachment['filename']);
        }

        $this->_response->setHeader('ETag', '"' . $attachment['attach_date'] . '"', true);
        $this->_response->setHeader('Content-Length', $attachment['file_size'], true);
        $this->_response->setHeader('X-Content-Type-Options', 'nosniff');

        return new XenForo_FileOutput($this->_params['attachmentFile']);
    }
}