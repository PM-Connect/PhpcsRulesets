<?php declare(strict_types = 1);

namespace PMConnectProductStrict\Sniffs\Functions;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\FunctionHelper;
use SlevomatCodingStandard\Helpers\SuppressHelper;
use SlevomatCodingStandard\Helpers\TokenHelper;
use SlevomatCodingStandard\Helpers\VariableHelper;
use function sprintf;
use const T_CLOSURE;
use const T_FUNCTION;
use const T_VARIABLE;

class ParameterCountSniff implements Sniff
{

	private const NAME = 'PMConnectProductStrict.Functions.ParameterCount';

	public const CODE_PARAMETER_COUNT = 'ParameterCount';

	/** @var int */
    public $maxNumberOfParameters = 7;

	/**
	 * @return (int|string)[]
	 */
	public function register(): array
	{
		return [
			T_FUNCTION,
			T_CLOSURE,
		];
	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile
	 * @param int $functionPointer
	 */
	public function process(File $phpcsFile, $functionPointer): void
	{
        if (SuppressHelper::isSniffSuppressed($phpcsFile, $functionPointer, $this->getSniffName(self::CODE_PARAMETER_COUNT))) {
            return;
        }

		$names = FunctionHelper::getParametersNames($phpcsFile, $functionPointer);

		if (count($names) >= $this->maxNumberOfParameters) {
            $phpcsFile->addError(sprintf('Too many parameters in %s, expected less than %d.', FunctionHelper::getName($phpcsFile, $functionPointer), $this->maxNumberOfParameters), $functionPointer, self::CODE_PARAMETER_COUNT);
        }
	}

	private function getSniffName(string $sniffName): string
	{
		return sprintf('%s.%s', self::NAME, $sniffName);
	}

}
