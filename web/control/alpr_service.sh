if [ -z "$1"]; then
    echo "Erro";
fi

imagem="$1"

result=$(alpr -c br "$imagem")

echo "$result"