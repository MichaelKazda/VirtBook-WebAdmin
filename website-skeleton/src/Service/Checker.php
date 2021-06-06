<?php
namespace App\Service;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Checker
{
    /**
     * Returns array of remembered input values, if form isnt complete
     * @param array $memArr
     * @param string $index
     * @param array $postData
     * @return array
     */
    public function inputMem(array $memArr, string $index, array $postData): array{
        if(!empty($postData[$index])){
            $memArr[$index] = $postData[$index];
        }
        return $memArr;
    }
}