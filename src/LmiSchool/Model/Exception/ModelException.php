<?php
namespace LmiSchool\Model\Exception;

use Exception;
use RuntimeException;

/**
 * @author Dmitry Landa <dmitry.landa@yandex.ru>
 */
class ModelException extends RuntimeException
{
    /**
     * @param Exception $previousException
     * @return ModelException
     */
    public static function failedToInsert(Exception $previousException)
    {
        return new self(sprintf('При добавлении новой записи произошла ошибка', null, $previousException));
    }

    /**
     * @param Exception $previousException
     * @return ModelException
     */
    public static function failedToUpdate(Exception $previousException)
    {
        return new self(sprintf('При обновлении данных произошла ошибка', null, $previousException));
    }

    /**
     * @param Exception $previousException
     * @return ModelException
     */
    public static function failedToRemove(Exception $previousException)
    {
        return new self(sprintf('При удалении новой записи произошла ошибка', null, $previousException));
    }

}
