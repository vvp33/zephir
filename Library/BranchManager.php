<?php

/*
 +--------------------------------------------------------------------------+
 | Zephir Language                                                          |
 +--------------------------------------------------------------------------+
 | Copyright (c) 2013-2014 Zephir Team and contributors                     |
 +--------------------------------------------------------------------------+
 | This source file is subject the MIT license, that is bundled with        |
 | this package in the file LICENSE, and is available through the           |
 | world-wide-web at the following url:                                     |
 | http://zephir-lang.com/license.html                                      |
 |                                                                          |
 | If you did not receive a copy of the MIT license and are unable          |
 | to obtain it through the world-wide-web, please send a note to           |
 | license@zephir-lang.com so we can mail you a copy immediately.           |
 +--------------------------------------------------------------------------+
*/

namespace Zephir;

/**
 * BranchManager
 *
 * Records every branch created within a method allowing analyze conditional variable assignment
 */
class BranchManager
{
    protected $_currentBranch;

    protected $_level = 0;

    protected $_uniqueId = 1;

    /**
     * Sets the current active branch in the manager
     *
     * @param Branch $branch
     */
    public function addBranch(Branch $branch)
    {
        if ($this->_currentBranch) {
            $branch->setParentBranch($this->_currentBranch);
            $this->_currentBranch = $branch;
        } else {
            $this->_currentBranch = $branch;
        }

        $branch->setUniqueId($this->_uniqueId);
        $branch->setLevel($this->_level);

        $this->_level++;
        $this->_uniqueId++;
    }

    /**
     * Removes a branch from the branch manager
     *
     * @param Branch $branch
     */
    public function removeBranch(Branch $branch)
    {
        $parentBranch = $branch->getParentBranch();
        $this->_currentBranch = $parentBranch;
        $this->_level--;
    }

    /**
     * Returns the active branch in the manager
     *
     * @return Branch
     */
    public function getCurrentBranch()
    {
        return $this->_currentBranch;
    }
}
