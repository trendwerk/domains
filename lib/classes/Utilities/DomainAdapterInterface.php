<?php
namespace Trendwerk\Domains\Utilities;

interface DomainAdapterInterface
{
    public function getCurrentByDomain();
    
    public function getCurrentById();
}
