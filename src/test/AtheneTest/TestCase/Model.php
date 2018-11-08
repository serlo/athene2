<?php
/**
 * This file is part of Athene2.
 *
 * Copyright (c) 2013-2018 Serlo Education e.V.
 *
 * Licensed under the Apache License, Version 2.0 (the "License")
 * you may not use this file except in compliance with the License
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @copyright Copyright (c) 2013-2018 Serlo Education e.V.
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace AtheneTest\TestCase;

abstract class Model extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @return array
     */
    abstract protected function getData();

    private $object;
    private $data;

    /**
     *
     * @return field_type $reference
     */
    protected function getObject()
    {
        return $this->object;
    }

    /**
     *
     * @param field_type $reference
     * @return $this
     */
    protected function setObject($object)
    {
        $this->object = $object;
        return $this;
    }

    protected function inject()
    {
        if (! is_array($this->data)) {
            $this->data = $this->getData();
        }

        foreach ($this->data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this->getObject(), $method)) {
                $this->assertSame($this->getObject(), $this->getObject()
                    ->$method($value));
            }
        }
        return $this;
    }

    public function testSetter()
    {
        $object = $this->getObject();
        $this->inject();
    }

    public function testGetter()
    {
        $object = $this->getObject();
        $this->inject();
        foreach ($this->data as $key => $value) {
            $method = 'get' . ucfirst($key);
            if (method_exists($object, $method)) {
                if (is_object($object->$method())) {
                    $this->assertSame($value, $object->$method(), $method);
                } else {
                    $this->assertEquals($value, $object->$method(), $method);
                }
            }
        }
    }
}
