<?php

namespace App\Controller;

use App\Service\DateParser;
use App\Repository\ParsedDateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use InvalidArgumentException;

class ApiController extends AbstractController
{
    public function __construct(private ParsedDateRepository $repo) {}

    #[Route('/api/parse', name: 'api_parse', methods: ['POST'])]
    public function parse(Request $request, DateParser $parser): JsonResponse
    {
        $dateInput = (string) $request->get('date', '');

        try {
            $parsed = $parser->parse($dateInput);
        } catch (InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }

        $this->repo->incrementCount($parsed);

        return $this->json($parsed);
    }

    #[Route('/api/parsed', name: 'api_parsed', methods: ['GET'])]
    public function parsed(): JsonResponse
    {
        $rows = $this->repo->findAllParsed();

        return $this->json(['parsed' => $rows]);
    }
}
