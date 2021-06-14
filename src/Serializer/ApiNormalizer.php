<?php
// api/src/Serializer/ApiNormalizer

namespace App\Serializer;

use App\Entity\Support;
use App\Entity\SupportHasTag;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class ApiNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    private $decorated;

    protected $em;

    public function __construct(NormalizerInterface $decorated, EntityManagerInterface $em)
    {
        if (!$decorated instanceof DenormalizerInterface) {
            throw new \InvalidArgumentException(sprintf('The decorated normalizer must implement the %s.', DenormalizerInterface::class));
        }

        $this->em = $em;
        $this->decorated = $decorated;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    public function normalize($object, $format = null, array $context = [])
    {
        return $this->decorated->normalize($object, $format, $context);
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        /*if ($data["tags"]) {
            $support = $this->em->getRepository(Support::class)->find($data["tags"][0]);
            unset($data["tags"][0]);
            $listTagsExist = $this->em->getRepository(Tag::class)->findAllTagsBySupport($support->getId());
            foreach ($listTagsExist as $tagExist) {
                $ExistingTagsName[] = $tagExist["name"];
            }
            $tagsToDelete = array_diff($ExistingTagsName, $data["tags"]);
            $tagsToAdd = array_diff($data["tags"], $ExistingTagsName);
            if (!empty($tagsToDelete)) {
                $this->em->getRepository(SupportHasTag::class)->removeBySupportAndTagsList($support->getId(), $tagsToDelete);
            }
            if (!empty($tagsToAdd)) {
                foreach ($tagsToAdd as $tagToAdd) {
                    $tag = $this->em->getRepository(Tag::class)->findOneBy(["name" => $tagToAdd]);
                    if ($tag === NULL) {
                        $tag = new Tag();
                        $tag->setName($tagToAdd);
                    }
                    $supportHasTag = new SupportHasTag();
                    $supportHasTag->setSupport($support);
                    $supportHasTag->setTag($tag);
                    $this->em->persist($tag);
                    $this->em->persist($supportHasTag);
                }
                $this->em->flush();
            }
        }
        unset($data["tags"]);
        dump($data);
        die();*/
        //unset($data["tags"]);
        //dump($data);
        //die();
        return $this->decorated->supportsDenormalization($data, $type, $format);
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return $this->decorated->denormalize($data, $class, $format, $context);
    }

    public function setSerializer(SerializerInterface $serializer)
    {
        if($this->decorated instanceof SerializerAwareInterface) {
            $this->decorated->setSerializer($serializer);
        }
    }
}