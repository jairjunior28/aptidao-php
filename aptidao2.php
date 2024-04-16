<?php

class Node {
    public $value;
    public $left;
    public $right;
    public $height;

    public function __construct($value) {
        $this->value = $value;
        $this->left = null;
        $this->right = null;
        $this->height = 1;
    }
}

class AVLTree {
    private $root;

    private function height($node) {
        return $node ? $node->height : 0;
    }

    private function updateHeight($node) {
        $node->height = 1 + max($this->height($node->left), $this->height($node->right));
    }

    private function balanceFactor($node) {
        return $node ? $this->height($node->left) - $this->height($node->right) : 0;
    }

    private function rotateRight($y) {
        $x = $y->left;
        $T2 = $x->right;

        $x->right = $y;
        $y->left = $T2;

        $this->updateHeight($y);
        $this->updateHeight($x);

        return $x;
    }

    private function rotateLeft($x) {
        $y = $x->right;
        $T2 = $y->left;

        $y->left = $x;
        $x->right = $T2;

        $this->updateHeight($x);
        $this->updateHeight($y);

        return $y;
    }

    public function insert($value) {
        $this->root = $this->insertNode($this->root, $value);
    }

    private function insertNode($node, $value) {
        if (!$node) {
            return new Node($value);
        }

        if ($value < $node->value) {
            $node->left = $this->insertNode($node->left, $value);
        } elseif ($value > $node->value) {
            $node->right = $this->insertNode($node->right, $value);
        } else {
            return $node;
        }

        $this->updateHeight($node);

        $balance = $this->balanceFactor($node);

        if ($balance > 1 && $value < $node->left->value) {
            return $this->rotateRight($node);
        }

        if ($balance < -1 && $value > $node->right->value) {
            return $this->rotateLeft($node);
        }

        if ($balance > 1 && $value > $node->left->value) {
            $node->left = $this->rotateLeft($node->left);
            return $this->rotateRight($node);
        }

        if ($balance < -1 && $value < $node->right->value) {
            $node->right = $this->rotateRight($node->right);
            return $this->rotateLeft($node);
        }

        return $node;
    }

    public function remove($value) {
        $this->root = $this->removeNode($this->root, $value);
    }

    private function removeNode($node, $value) {
        if (!$node) {
            return null;
        }

        if ($value < $node->value) {
            $node->left = $this->removeNode($node->left, $value);
        } elseif ($value > $node->value) {
            $node->right = $this->removeNode($node->right, $value);
        } else {
            if (!$node->left || !$node->right) {
                $node = $node->left ?: $node->right;
            } else {
                $temp = $this->minValueNode($node->right);
                $node->value = $temp->value;
                $node->right = $this->removeNode($node->right, $temp->value);
            }
        }

        if (!$node) {
            return null;
        }

        $this->updateHeight($node);

        $balance = $this->balanceFactor($node);

        if ($balance > 1 && $this->balanceFactor($node->left) >= 0) {
            return $this->rotateRight($node);
        }

        if ($balance > 1 && $this->balanceFactor($node->left) < 0) {
            $node->left = $this->rotateLeft($node->left);
            return $this->rotateRight($node);
        }

        if ($balance < -1 && $this->balanceFactor($node->right) <= 0) {
            return $this->rotateLeft($node);
        }

        if ($balance < -1 && $this->balanceFactor($node->right) > 0) {
            $node->right = $this->rotateRight($node->right);
            return $this->rotateLeft($node);
        }

        return $node;
    }

    private function minValueNode($node) {
        $current = $node;
        while ($current->left) {
            $current = $current->left;
        }
        return $current;
    }

    public function inorder() {
        $this->inorderTraversal($this->root);
    }

    private function inorderTraversal($node) {
        if ($node) {
            $this->inorderTraversal($node->left);
            echo $node->value . " ";
            $this->inorderTraversal($node->right);
        }
    }
}

// Exemplo de utilização
$tree = new AVLTree();

$tree->insert(8);
$tree->insert(2);
$tree->insert(4);
$tree->insert(8);
$tree->insert(5);
$tree->insert(4);
$tree->insert(3);
$tree->insert(1);
$tree->insert(10);

echo "Árvore AVL após inserção: ";
$tree->inorder();
echo "\n";

$tree->remove(5);

echo "Árvore AVL após remoção do valor 5: ";
$tree->inorder();
echo "\n";
?>
