<?php
namespace Yurun\Crawler\Test\Module\YurunBlog\Model\Base;

use Imi\Model\Model;
use Imi\Model\Annotation\DDL;
use Imi\Model\Annotation\Table;
use Imi\Model\Annotation\Column;
use Imi\Model\Annotation\Entity;

/**
 * tb_article 基类
 * @Entity
 * @Table(name="tb_article", id={"id"})
 * @DDL("CREATE TABLE `tb_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` mediumtext NOT NULL COMMENT '内容',
  `time` datetime NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8")
 * @property int $id 
 * @property string $title 标题
 * @property string $content 内容
 * @property string $time 时间
 */
abstract class ArticleBase extends Model
{
    /**
     * id
     * @Column(name="id", type="int", length=10, accuracy=0, nullable=false, default="", isPrimaryKey=true, primaryKeyIndex=0, isAutoIncrement=true)
     * @var int
     */
    protected $id;

    /**
     * 获取 id
     *
     * @return int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * 赋值 id
     * @param int $id id
     * @return static
     */ 
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * 标题
     * title
     * @Column(name="title", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string
     */
    protected $title;

    /**
     * 获取 title - 标题
     *
     * @return string
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 赋值 title - 标题
     * @param string $title title
     * @return static
     */ 
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * 内容
     * content
     * @Column(name="content", type="mediumtext", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string
     */
    protected $content;

    /**
     * 获取 content - 内容
     *
     * @return string
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 赋值 content - 内容
     * @param string $content content
     * @return static
     */ 
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * 时间
     * time
     * @Column(name="time", type="datetime", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string
     */
    protected $time;

    /**
     * 获取 time - 时间
     *
     * @return string
     */ 
    public function getTime()
    {
        return $this->time;
    }

    /**
     * 赋值 time - 时间
     * @param string $time time
     * @return static
     */ 
    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }

}
