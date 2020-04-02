<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index as Index;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 * @ORM\Table(name="videos", indexes={@Index(name="title_idx", columns={"title"})})
 */
class Video
{

//    public const videoForNotLoggedIn = 113716040; //vimeo Id
    public const videoForNotLoggedInOrNoMembers = 'https://player.vimeo.com/video/113716040';
    public const VimeoPath = 'https://player.vimeo.com/video/';
    public const perPage = 5; // for pagination
    public const uploadFolder = '/uploads/videos/';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="videos")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="video")
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="likedVideos")
     * @ORM\JoinTable(name="likes")
     *
     */
    private $UserThatLike;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="dislikedVideos")
     * @ORM\JoinTable(name="dislikes")
     */
    private $usersThatDontLike;

    /**
     * @Assert\NotBlank(message="Please, upload the video as a MP4 file.")
     * @Assert\File(mimeTypes={"video/mp4"})
     */
    private $uploaded_video;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->UserThatLike = new ArrayCollection();
        $this->usersThatDontLike = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

//    public function getVimeoId($user) : ?string{
    public function getVimeoId() {
        if (strpos($this->path,self::uploadFolder) !==false){
            return $this->path;
        }
        $array = explode('/',$this->path);
        return end($array);
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setVideo($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getVideo() === $this) {
                $comment->setVideo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserThatLike(): Collection
    {
        return $this->UserThatLike;
    }

    public function addUserThatLike(User $userThatLike): self
    {
        if (!$this->UserThatLike->contains($userThatLike)) {
            $this->UserThatLike[] = $userThatLike;
        }

        return $this;
    }

    public function removeUserThatLike(User $userThatLike): self
    {
        if ($this->UserThatLike->contains($userThatLike)) {
            $this->UserThatLike->removeElement($userThatLike);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsersThatDontLike(): Collection
    {
        return $this->usersThatDontLike;
    }

    public function addUsersThatDontLike(User $usersThatDontLike): self
    {
        if (!$this->usersThatDontLike->contains($usersThatDontLike)) {
            $this->usersThatDontLike[] = $usersThatDontLike;
        }

        return $this;
    }

    public function removeUsersThatDontLike(User $usersThatDontLike): self
    {
        if ($this->usersThatDontLike->contains($usersThatDontLike)) {
            $this->usersThatDontLike->removeElement($usersThatDontLike);
        }

        return $this;
    }

    public function getUploadedVideo()
    {
        return $this->uploaded_video;
    }

    public function setUploadedVideo($uploaded_video): self
    {
        $this->uploaded_video = $uploaded_video;

        return $this;
    }
}
