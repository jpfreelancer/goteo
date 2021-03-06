<?php

namespace Goteo\Model\Call {

    use Goteo\Model,
        Goteo\Model\Image;
    use Goteo\Application\Lang;
    use Goteo\Application\Config;

    class Post extends \Goteo\Core\Model {

        public
            $id,
            $call;


        /**
         * Get the posts assigned to a call
         * @param varcahr(50) $id  Call identifier
         * @return instance of post
         */
		public static function get ($call, $lang=null, $model_lang=null) {

            $debug = false;

            $list = array();
            $values = array(':call'=>$call);

            if(!$model_lang) $model_lang = Config::get('lang');
            list($fields, $joins) = self::getLangsSQLJoins($lang, $model_lang, null, 'Goteo\Model\Blog\Post');


            // image, author, id, title, text
            $sql = "SELECT
                        post.id as id,
                        post.blog as blog,
                        post.slug as slug,
                        $fields,
                        post.image as `image`,
                        post.header_image as `header_image`,
                        DATE_FORMAT(post.date, '%d-%m-%Y') as date,
                        DATE_FORMAT(post.date, '%d | %m | %Y') as fecha,
                        post.author as author,
                        user.name as user_name
                    FROM call_post
                    INNER JOIN post
                      ON post.id = call_post.post
                    LEFT JOIN user
                      ON user.id = post.author
                    $joins
                    WHERE call_post.call = :call
                    ORDER BY post.date DESC, post.id DESC
                    ";


            // echo \sqldbg($sql, $values);die;

            $query = static::query($sql, $values);
            foreach ($query->fetchAll(\PDO::FETCH_CLASS, 'Goteo\Model\Blog\Post') as $post) {

                $post->gallery = Image::getModelGallery('post', $post->id);
                $post->image = Image::getModelImage($post->image, $post->gallery);
                $post->header_image = Image::getModelImage($post->header_image);

                $list[] = $post;
            }

            return $list;
		}

		public function validate(&$errors = array()) {
            // Estos son errores que no permiten continuar
            if (empty($this->id))
                $errors[] = 'No hay ninguna entrada para guardar';

            if (empty($this->call))
                $errors[] = 'No hay ningun proyecto al que asignar';

            //cualquiera de estos errores hace fallar la validación
            if (!empty($errors))
                return false;
            else
                return true;
        }

		public function save (&$errors = array()) {
            if (!$this->validate($errors)) return false;

			try {
	            $sql = "REPLACE INTO call_post (`call`, post) VALUES(:call, :post)";
                $values = array(':call'=>$this->call, ':post'=>$this->id);
				if (self::query($sql, $values)) {
    				return true;
                } else {
                    $errors[] = "$sql <pre>".print_r($values, true)."</pre>";
                }
			} catch(\PDOException $e) {
				$errors[] = "La entrada {$this->id} no se ha asignado correctamente. Por favor, revise los datos." . $e->getMessage();
                return false;
			}

		}

		/**
		 * Quitar una palabra clave de un proyecto
		 *
		 * @param varchar(50) $call id de un proyecto
		 * @param INT(12) $id  identificador de la tabla keyword
		 * @param array $errors
		 * @return boolean
		 */
		public function remove (&$errors = array()) {
			$values = array (
				':call'=>$this->call,
				':post'=>$this->id,
			);

			try {
                $sql = "DELETE FROM call_post WHERE post = :post AND `call` = :call";
                if (self::query($sql, $values)) {
                    return true;
                } else {
                    $errors[] = "$sql <pre>".print_r($values, true)."</pre>";
                }
			} catch(\PDOException $e) {
				$errors[] = 'No se ha podido quitar la entrada ' . $this->id . ' de la convocatoria ' . $this->call . ' ' . $e->getMessage();
                //Text::get('remove-post-fail');
                return false;
			}
		}

    }

}
